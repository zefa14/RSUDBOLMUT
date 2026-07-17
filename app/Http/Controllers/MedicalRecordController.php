<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Registration;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor', 'department', 'prescriptions'])->latest('record_date')->latest();

        // Jika user adalah Dokter, hanya tampilkan rekam medis milik dokter tsb
        $user = auth()->user();
        if ($user->isDoctor()) {
            $doctorId = $user->doctor?->id;
            $query->where('doctor_id', $doctorId);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('patient_code', 'like', "%{$search}%");
            });
        }

        $records = $query->paginate(15)->withQueryString();
        return view('medical_records.index', compact('records'));
    }

    public function create(Request $request)
    {
        $registration = null;
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $medicines = Medicine::where('active', true)->orderBy('name')->get();

        if ($request->registration_id) {
            $registration = Registration::with(['patient', 'doctor', 'department'])
                ->findOrFail($request->registration_id);
                
            // Update status ke 'serving' (sedang diperiksa) saat dokter membuka form ini
            if ($registration->status == 'waiting') {
                $registration->update(['status' => 'serving']);
            }
        }

        return view('medical_records.create', compact('registration', 'patients', 'doctors', 'departments', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'doctor_id'      => 'required|exists:doctors,id',
            'department_id'  => 'required|exists:departments,id',
            'record_date'    => 'required|date',
            // SOAP Fields
            'subjective'     => 'nullable|string',
            'objective'      => 'nullable|string',
            'blood_pressure' => 'nullable|string|max:20',
            'temperature'    => 'nullable|numeric',
            'weight'         => 'nullable|numeric',
            'height'         => 'nullable|numeric',
            'assessment'     => 'required|string',
            'plan'           => 'nullable|string',
            'icd10_code'     => 'nullable|string|max:10',
            // Legacy fallbacks (optional, we can map SOAP to these or just make them nullable)
            'complaint'      => 'nullable|string',
            'diagnosis'      => 'nullable|string',
            'treatment'      => 'nullable|string',
            // Validasi array resep obat
            'medicines.*'    => 'nullable|exists:medicines,id',
            'quantities.*'   => 'nullable|numeric|min:1',
            'dosages.*'      => 'nullable|string',
            'instructions.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan Rekam Medis
            $record = MedicalRecord::create([
                'patient_id'     => $request->patient_id,
                'doctor_id'      => $request->doctor_id,
                'department_id'  => $request->department_id,
                'record_date'    => $request->record_date,
                'subjective'     => $request->subjective,
                'objective'      => $request->objective,
                'blood_pressure' => $request->blood_pressure,
                'temperature'    => $request->temperature,
                'weight'         => $request->weight,
                'height'         => $request->height,
                'assessment'     => $request->assessment,
                'plan'           => $request->plan,
                'icd10_code'     => $request->icd10_code,
                // Map to legacy if needed or let them be null
                'complaint'      => $request->subjective ?? $request->complaint,
                'diagnosis'      => $request->assessment ?? $request->diagnosis,
                'treatment'      => $request->plan ?? $request->treatment,
            ]);

            // 2. Simpan Resep Obat (jika ada)
            if ($request->has('medicines')) {
                foreach ($request->medicines as $key => $medicine_id) {
                    if ($medicine_id && $request->quantities[$key]) {
                        Prescription::create([
                            'medical_record_id' => $record->id,
                            'medicine_id'       => $medicine_id,
                            'quantity'          => $request->quantities[$key],
                            'dosage'            => $request->dosages[$key] ?: '-',
                            'instructions'      => $request->instructions[$key] ?? null,
                        ]);
                    }
                }
            }

            // 3. Update status Pendaftaran menjadi 'done'
            if ($request->registration_id) {
                Registration::where('id', $request->registration_id)->update(['status' => 'done']);
            }

            DB::commit();

            return redirect()->route('medical_records.index')
                ->with('success', 'Rekam Medis & Resep Obat berhasil disimpan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $record = MedicalRecord::with(['patient', 'doctor', 'department', 'prescriptions.medicine'])
            ->findOrFail($id);

        // Jika user adalah Dokter, cek apakah rekam medis ini miliknya
        $user = auth()->user();
        if ($user->isDoctor()) {
            $doctorId = $user->doctor?->id;
            if ($record->doctor_id !== $doctorId) {
                abort(403, 'Anda tidak memiliki akses untuk melihat rekam medis milik dokter lain.');
            }
        }

        return view('medical_records.show', compact('record'));
    }

    public function edit($id)
    {
        // Untuk sederhananya, Rekam Medis biasanya tidak boleh diedit setelah di-submit (Medikolegal), 
        // tapi kita bisa tambahkan fungsi amandemen di masa depan.
        return redirect()->route('medical_records.index')
            ->with('error', 'Rekam Medis tidak dapat diubah setelah disimpan untuk alasan rekam jejak medis.');
    }

    public function update(Request $request, $id)
    {
        // 
    }

    public function destroy($id)
    {
        // Medical Record jarang dihapus, namun untuk sistem ini kita beri fitur hapus untuk Admin
        $record = MedicalRecord::findOrFail($id);
        $record->prescriptions()->delete();
        $record->delete();

        return redirect()->route('medical_records.index')
            ->with('success', 'Rekam Medis berhasil dihapus!');
    }

    public function getActiveRegistration($patient_id)
    {
        $registration = Registration::where('patient_id', $patient_id)
            ->whereDate('registration_date', Carbon::today())
            ->whereIn('status', ['waiting', 'serving'])
            ->latest('id')
            ->first();

        if ($registration) {
            return response()->json([
                'success' => true,
                'registration_id' => $registration->id,
                'department_id' => $registration->department_id,
                'doctor_id' => $registration->doctor_id,
                'complaint' => $registration->complaint
            ]);
        }

        return response()->json(['success' => false]);
    }
}
