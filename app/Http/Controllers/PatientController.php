<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query()->latest();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        $patients = $query->paginate(10)->withQueryString();

        $totalPatients = Patient::count();
        $totalMale = Patient::whereIn('gender', ['L', 'male'])->count();
        $totalFemale = Patient::whereIn('gender', ['P', 'female'])->count();

        return view('patients.index', compact(
            'patients',
            'totalPatients',
            'totalMale',
            'totalFemale'
        ));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'         => 'required|string|max:20|unique:patients,nik',
            'bpjs_number' => 'nullable|string|max:20|unique:patients,bpjs_number',
            'name'        => 'required|string|max:255',
            'gender'      => 'required|in:L,P,male,female',
            'blood_type'  => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'birth_date'  => 'required|date|before:today',
            'birth_place' => 'nullable|string|max:255',
            'religion'    => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'education'   => 'nullable|string|max:50',
            'occupation'  => 'nullable|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email|max:255',
            'address'     => 'required|string',
            'rt_rw'       => 'nullable|string|max:10',
            'kelurahan'   => 'nullable|string|max:100',
            'kecamatan'   => 'nullable|string|max:100',
            'kabupaten'   => 'nullable|string|max:100',
            'provinsi'    => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'emergency_contact_name'     => 'nullable|string|max:255',
            'emergency_contact_phone'    => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active'   => 'boolean',
            'notes'       => 'nullable|string',
            'allergy_notes' => 'nullable|string',
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('patients', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Patient::create($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Data Pasien berhasil didaftarkan!');
    }

    public function show(Patient $patient)
    {
        $patient->load(['registrations' => function($q) {
            $q->latest()->take(5)->with(['doctor', 'department']);
        }]);
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nik'         => 'required|string|max:20|unique:patients,nik,' . $patient->id,
            'bpjs_number' => 'nullable|string|max:20|unique:patients,bpjs_number,' . $patient->id,
            'name'        => 'required|string|max:255',
            'gender'      => 'required|in:L,P,male,female',
            'blood_type'  => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'birth_date'  => 'required|date|before:today',
            'birth_place' => 'nullable|string|max:255',
            'religion'    => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'education'   => 'nullable|string|max:50',
            'occupation'  => 'nullable|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email|max:255',
            'address'     => 'required|string',
            'rt_rw'       => 'nullable|string|max:10',
            'kelurahan'   => 'nullable|string|max:100',
            'kecamatan'   => 'nullable|string|max:100',
            'kabupaten'   => 'nullable|string|max:100',
            'provinsi'    => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'emergency_contact_name'     => 'nullable|string|max:255',
            'emergency_contact_phone'    => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active'   => 'boolean',
            'notes'       => 'nullable|string',
            'allergy_notes' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            if ($patient->photo && Storage::disk('public')->exists($patient->photo)) {
                Storage::disk('public')->delete($patient->photo);
            }
            $validated['photo'] = $request->file('photo')->store('patients', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $patient->update($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Data Pasien berhasil diperbarui!');
    }

    public function destroy(Patient $patient)
    {
        if ($patient->registrations()->count() > 0) {
            return redirect()->route('patients.index')
                ->with('error', 'Gagal menghapus! Pasien ini memiliki riwayat kunjungan.');
        }

        if ($patient->photo && Storage::disk('public')->exists($patient->photo)) {
            Storage::disk('public')->delete($patient->photo);
        }

        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Data Pasien berhasil dihapus!');
    }
}