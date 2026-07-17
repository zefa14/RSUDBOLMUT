<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('department')->latest();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        $doctors = $query->paginate(10)->withQueryString();
        $totalDoctors = Doctor::count();

        return view('doctors.index', compact('doctors', 'totalDoctors'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'department_id'  => 'required|exists:departments,id',
            'phone'          => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'str_number'     => 'nullable|string|max:50',
            'sip_number'     => 'nullable|string|max:50',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active'      => 'boolean',
            'notes'          => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Doctor::create($validated);

        return redirect()->route('doctors.index')
            ->with('success', 'Data Dokter berhasil ditambahkan!');
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::all();
        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'department_id'  => 'required|exists:departments,id',
            'phone'          => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'str_number'     => 'nullable|string|max:50',
            'sip_number'     => 'nullable|string|max:50',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active'      => 'boolean',
            'notes'          => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($doctor->photo && Storage::disk('public')->exists($doctor->photo)) {
                Storage::disk('public')->delete($doctor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $doctor->update($validated);

        return redirect()->route('doctors.index')
            ->with('success', 'Data Dokter berhasil diperbarui!');
    }

    public function destroy(Doctor $doctor)
    {
        // Cek relasi
        if ($doctor->registrations()->count() > 0) {
            return redirect()->route('doctors.index')
                ->with('error', 'Gagal menghapus! Dokter ini sudah memiliki riwayat pendaftaran pasien.');
        }

        // Hapus foto jika ada
        if ($doctor->photo && Storage::disk('public')->exists($doctor->photo)) {
            Storage::disk('public')->delete($doctor->photo);
        }

        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', 'Data Dokter berhasil dihapus!');
    }

    public function schedules(Doctor $doctor)
    {
        $schedules = $doctor->schedules()->orderBy('day_of_week')->orderBy('start_time')->get();
        return view('doctors.schedules', compact('doctor', 'schedules'));
    }

    public function storeSchedules(Request $request, Doctor $doctor)
    {
        $request->validate([
            'schedules' => 'array',
            'schedules.*.day_of_week' => 'required|integer|min:1|max:7',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i|after:schedules.*.start_time',
        ]);

        // Hapus semua jadwal lama
        $doctor->schedules()->delete();

        // Simpan jadwal baru jika ada
        if ($request->has('schedules')) {
            foreach ($request->schedules as $schedule) {
                $doctor->schedules()->create([
                    'day_of_week' => $schedule['day_of_week'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'max_patients' => 50, // default
                    'is_active' => true,
                ]);
            }
        }

        return redirect()->route('doctors.index')->with('success', 'Jadwal dokter berhasil diperbarui.');
    }
}