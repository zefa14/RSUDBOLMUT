<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['patient', 'doctor', 'department'])->latest('registration_date')->latest();

        // Filter berdasarkan tanggal (default hari ini)
        $dateFilter = $request->input('date');
        if ($dateFilter) {
            $query->whereDate('registration_date', $dateFilter);
        } else {
            // Default tampilkan semua tapi didahulukan hari ini
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $registrations = $query->paginate(15)->withQueryString();
        
        $todayCount = Registration::whereDate('registration_date', Carbon::today())->count();
        $waitingCount = Registration::whereDate('registration_date', Carbon::today())->where('status', 'waiting')->count();

        return view('registrations.index', compact('registrations', 'todayCount', 'waitingCount', 'dateFilter'));
    }

    public function create(Request $request)
    {
        // Jika ada patient_id dari URL (dari Profil Pasien -> Daftarkan)
        $selectedPatient = null;
        if ($request->has('patient_id')) {
            $selectedPatient = Patient::find($request->patient_id);
        }

        $patients = Patient::select('id', 'patient_code', 'name', 'nik', 'bpjs_number')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('registrations.create', compact('patients', 'departments', 'selectedPatient'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'registration_date' => 'required|date',
            'visit_type' => 'required|in:baru,lama,kontrol',
            'complaint' => 'nullable|string',
            'initial_diagnosis' => 'nullable|string',
            'registration_notes' => 'nullable|string',
            'payment_method' => 'required|in:umum,bpjs,asuransi,perusahaan,jamkesda',
            'bpjs_class' => 'nullable|in:1,2,3',
            'sep_number' => 'nullable|string|max:50',
            'referral_number' => 'nullable|required_if:payment_method,bpjs|string|max:50',
            'referral_origin' => 'nullable|string|max:255',
            'referral_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $referralFilePath = null;
        if ($request->hasFile('referral_file')) {
            $referralFilePath = $request->file('referral_file')->store('referrals', 'public');
        }

        // Generate Nomor Antrian untuk poli tersebut pada hari tersebut
        $date = Carbon::parse($request->registration_date)->toDateString();
        $dept = Department::find($request->department_id);
        
        // Ambil inisial Poli (misal "Poli Gigi" -> "PG")
        $words = explode(" ", $dept->name);
        $prefix = "";
        foreach ($words as $w) {
            $prefix .= strtoupper(substr($w, 0, 1));
        }
        if(strlen($prefix) < 2) $prefix .= 'A';

        $lastQueue = Registration::where('department_id', $dept->id)
            ->whereDate('registration_date', $date)
            ->count();

        $queueNumber = $prefix . '-' . str_pad($lastQueue + 1, 3, '0', STR_PAD_LEFT);

        $isBpjs = $request->payment_method === 'bpjs';
        $hasReferral = in_array($request->payment_method, ['bpjs', 'asuransi']);

        $registration = Registration::create([
            'patient_id' => $request->patient_id,
            'department_id' => $request->department_id,
            'doctor_id' => $request->doctor_id,
            'registration_date' => $date,
            'queue_number' => $queueNumber,
            'visit_type' => $request->visit_type,
            'status' => 'waiting',
            'complaint' => $request->complaint,
            'initial_diagnosis' => $request->initial_diagnosis,
            'registration_notes' => $request->registration_notes,
            'payment_method' => $request->payment_method,
            'bpjs_class' => $isBpjs ? $request->bpjs_class : null,
            'sep_number' => $isBpjs ? $request->sep_number : null,
            'referral_number' => $hasReferral ? $request->referral_number : null,
            'referral_origin' => $hasReferral ? $request->referral_origin : null,
            'referral_file_path' => $hasReferral ? $referralFilePath : null,
        ]);

        return redirect()->route('registrations.show', $registration->id)
            ->with('success', 'Pendaftaran berhasil! Silakan cetak nomor antrian.');
    }

    public function show(Registration $registration)
    {
        $registration->load(['patient', 'doctor', 'department']);
        
        // Hitung antrian di depannya (yang statusnya masih waiting di poli yang sama hari ini)
        $queueAhead = Registration::where('department_id', $registration->department_id)
            ->whereDate('registration_date', $registration->registration_date)
            ->where('status', 'waiting')
            ->where('id', '<', $registration->id)
            ->count();

        return view('registrations.show', compact('registration', 'queueAhead'));
    }

    public function edit(Registration $registration)
    {
        $patients = Patient::select('id', 'patient_code', 'name', 'nik')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        // Dokter akan diload via AJAX/JavaScript di view berdasarkan department_id

        return view('registrations.edit', compact('registration', 'patients', 'departments'));
    }

    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'registration_date' => 'required|date',
            'visit_type' => 'nullable|in:baru,lama,kontrol',
            'status' => 'required|in:waiting,serving,done,cancelled',
            'complaint' => 'nullable|string',
            'initial_diagnosis' => 'nullable|string',
            'registration_notes' => 'nullable|string',
            'payment_method' => 'required|in:umum,bpjs,asuransi,perusahaan,jamkesda',
            'bpjs_class' => 'nullable|in:1,2,3',
            'sep_number' => 'nullable|string|max:50',
            'referral_number' => 'nullable|required_if:payment_method,bpjs|string|max:50',
            'referral_origin' => 'nullable|string|max:255',
            'referral_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $isBpjs = $request->payment_method === 'bpjs';
        $hasReferral = in_array($request->payment_method, ['bpjs', 'asuransi']);

        $data = [
            'patient_id' => $request->patient_id,
            'department_id' => $request->department_id,
            'doctor_id' => $request->doctor_id,
            'registration_date' => $request->registration_date,
            'visit_type' => $request->visit_type ?? $registration->visit_type,
            'status' => $request->status,
            'complaint' => $request->complaint,
            'initial_diagnosis' => $request->initial_diagnosis,
            'registration_notes' => $request->registration_notes,
            'payment_method' => $request->payment_method,
            'bpjs_class' => $isBpjs ? $request->bpjs_class : null,
            'sep_number' => $isBpjs ? $request->sep_number : null,
            'referral_number' => $hasReferral ? $request->referral_number : null,
            'referral_origin' => $hasReferral ? $request->referral_origin : null,
        ];

        if ($hasReferral && $request->hasFile('referral_file')) {
            $data['referral_file_path'] = $request->file('referral_file')->store('referrals', 'public');
        } elseif (!$hasReferral) {
            $data['referral_file_path'] = null;
        }

        $registration->update($data);

        return redirect()->route('registrations.index')
            ->with('success', 'Data Pendaftaran berhasil diperbarui.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('registrations.index')
            ->with('success', 'Data pendaftaran dibatalkan/dihapus.');
    }
}