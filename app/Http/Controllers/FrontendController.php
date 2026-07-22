<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Department;

class FrontendController extends Controller
{
    /**
     * Menampilkan halaman utama public (Landing Page)
     */
    public function index()
    {
        // Ambil data poli, dokter, dan kamar (dikelompokkan per bangsal) untuk ditampilkan di website publik
        $departments = Department::withCount('doctors')->get();
        $doctors = Doctor::with(['department', 'schedules' => function($q) {
            $q->orderBy('day_of_week', 'asc')->orderBy('start_time', 'asc');
        }])->where('is_active', true)->get();
        
        // Ambil bangsal yang memiliki kamar
        $wards = \App\Models\Ward::with('rooms')->whereHas('rooms')->get();
        $settings = json_decode(\Illuminate\Support\Facades\Storage::get('settings.json') ?? '{}', true);

        return view('frontend.welcome', compact('departments', 'doctors', 'wards', 'settings'));
    }

    /**
     * Menampilkan halaman khusus Tim Dokter
     */
    public function doctors()
    {
        $doctors = Doctor::with(['department', 'schedules' => function($q) {
            $q->orderBy('day_of_week', 'asc')->orderBy('start_time', 'asc');
        }])->where('is_active', true)->get();
        
        $settings = json_decode(\Illuminate\Support\Facades\Storage::get('settings.json') ?? '{}', true);

        return view('frontend.doctors', compact('doctors', 'settings'));
    }

    /**
     * Menampilkan halaman Galeri Khusus
     */
    public function galeri()
    {
        $settings = json_decode(\Illuminate\Support\Facades\Storage::get('settings.json') ?? '{}', true);
        
        return view('frontend.galeri', compact('settings'));
    }

    /**
     * Menampilkan halaman khusus Jadwal Poliklinik
     */
    public function jadwal()
    {
        $doctors = Doctor::with(['department', 'schedules' => function($q) {
            $q->orderBy('day_of_week', 'asc')->orderBy('start_time', 'asc');
        }])->where('is_active', true)->get();
        
        $settings = json_decode(\Illuminate\Support\Facades\Storage::get('settings.json') ?? '{}', true);

        return view('frontend.jadwal', compact('doctors', 'settings'));
    }

    /**
     * Menampilkan halaman khusus Pengaduan
     */
    public function pengaduan()
    {
        $settings = json_decode(\Illuminate\Support\Facades\Storage::get('settings.json') ?? '{}', true);

        return view('frontend.pengaduan', compact('settings'));
    }

    /**
     * Menampilkan halaman khusus Tentang
     */
    public function about()
    {
        $settings = json_decode(\Illuminate\Support\Facades\Storage::get('settings.json') ?? '{}', true);
        return view('frontend.about', compact('settings'));
    }

    /**
     * Menampilkan form pendaftaran online
     */
    public function registerForm()
    {
        $departments = Department::all();
        return view('frontend.register', compact('departments'));
    }

    /**
     * Memproses data pendaftaran online dari masyarakat
     */
    public function submitRegistration(Request $request)
    {
        $request->validate([
            // A. Data Identitas Pasien
            'nik'             => 'required|string|size:16',
            'name'            => 'required|string|max:255',
            'birth_place'     => 'required|string|max:100',
            'birth_date'      => 'required|date|before:today',
            'gender'          => 'required|in:L,P',
            'blood_type'      => 'nullable|in:A,B,AB,O',
            'religion'        => 'required|string|max:50',
            'marital_status'  => 'required|string|max:50',
            'education'       => 'nullable|string|max:50',
            'occupation'      => 'nullable|string|max:100',

            // B. Alamat Lengkap
            'address'         => 'required|string|max:500',
            'rt_rw'           => 'nullable|string|max:20',
            'kelurahan'       => 'required|string|max:100',
            'kecamatan'       => 'required|string|max:100',
            'kabupaten'       => 'required|string|max:100',
            'provinsi'        => 'required|string|max:100',
            'postal_code'     => 'nullable|string|max:5',

            // C. Kontak
            'phone'           => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',

            // D. Kontak Darurat
            'emergency_contact_name'     => 'required|string|max:255',
            'emergency_contact_phone'    => 'required|string|max:20',
            'emergency_contact_relation' => 'required|string|max:50',

            // E. Pemeriksaan
            'department_id'   => 'required|exists:departments,id',
            'doctor_id'       => 'required|exists:doctors,id',
            'complaint'       => 'required|string|max:1000',
            'allergy_notes'   => 'nullable|string|max:500',

            // F. Pembayaran
            'payment_method'  => 'required|in:umum,bpjs,asuransi',
            'bpjs_number'     => 'nullable|required_if:payment_method,bpjs|string|max:13',
            'referral_number' => 'nullable|required_if:payment_method,bpjs|string|max:50',
            'referral_file'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'nik.size'                        => 'NIK harus tepat 16 digit.',
            'birth_date.before'               => 'Tanggal lahir tidak boleh hari ini atau di masa depan.',
            'emergency_contact_name.required' => 'Nama penanggung jawab / kontak darurat wajib diisi.',
            'emergency_contact_phone.required'=> 'Nomor HP penanggung jawab wajib diisi.',
            'bpjs_number.required_if'         => 'Nomor kartu BPJS wajib diisi untuk pasien BPJS.',
            'referral_number.required_if'     => 'Nomor rujukan wajib diisi untuk pasien BPJS.',
        ]);

        $referralFilePath = null;
        if ($request->hasFile('referral_file')) {
            $referralFilePath = $request->file('referral_file')->store('referrals', 'public');
        }

        // Cek apakah pasien sudah ada berdasarkan NIK
        // Jika belum ada, buat Pasien Baru dengan data lengkap
        $patient = \App\Models\Patient::firstOrCreate(
            ['nik' => $request->nik],
            [
                'name'            => $request->name,
                'birth_date'      => $request->birth_date,
                'birth_place'     => $request->birth_place,
                'gender'          => $request->gender,
                'blood_type'      => $request->blood_type,
                'religion'        => $request->religion,
                'marital_status'  => $request->marital_status,
                'education'       => $request->education,
                'occupation'      => $request->occupation,
                'phone'           => $request->phone,
                'email'           => $request->email,
                'address'         => $request->address,
                'rt_rw'           => $request->rt_rw,
                'kelurahan'       => $request->kelurahan,
                'kecamatan'       => $request->kecamatan,
                'kabupaten'       => $request->kabupaten,
                'provinsi'        => $request->provinsi,
                'postal_code'     => $request->postal_code,
                'bpjs_number'     => $request->payment_method === 'bpjs' ? $request->bpjs_number : null,
                'emergency_contact_name'     => $request->emergency_contact_name,
                'emergency_contact_phone'    => $request->emergency_contact_phone,
                'emergency_contact_relation' => $request->emergency_contact_relation,
                'allergy_notes'   => $request->allergy_notes,
            ]
        );

        // Hitung nomor antrian hari ini di poli tersebut
        $today = \Carbon\Carbon::today();
        $queueCount = \App\Models\Registration::where('department_id', $request->department_id)
            ->whereDate('registration_date', $today)
            ->count();
            
        $department = Department::find($request->department_id);
        $prefix = strtoupper(substr($department->name, 0, 1));
        $queueNumber = $prefix . '-' . str_pad($queueCount + 1, 3, '0', STR_PAD_LEFT);

        // Buat Pendaftaran
        $registration = \App\Models\Registration::create([
            'patient_id'     => $patient->id,
            'department_id'  => $request->department_id,
            'doctor_id'      => $request->doctor_id,
            'registration_date' => $today,
            'queue_number'   => $queueNumber,
            'status'         => 'waiting',
            'payment_method' => $request->payment_method,
            'referral_number'    => $request->payment_method === 'bpjs' ? $request->referral_number : null,
            'referral_file_path' => $request->payment_method === 'bpjs' ? $referralFilePath : null,
            'complaint'      => $request->complaint,
        ]);

        return view('frontend.ticket', compact('registration'));
    }

    /**
     * API untuk AJAX Select Dokter
     */
    public function getDoctors($department_id)
    {
        $doctors = \App\Models\Doctor::where('department_id', $department_id)
                    ->where('is_active', true)
                    ->select('id', 'name', 'specialization')
                    ->get();
        return response()->json($doctors);
    }
}
