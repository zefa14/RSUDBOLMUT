<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data diambil dari foto daftar staf per Ruangan RSUD.
     */
    public function run(): void
    {
        // Pastikan Departemen / Ruangan ada
        $deptUGD   = Department::firstOrCreate(['name' => 'UGD'], ['description' => 'Unit Gawat Darurat']);
        $deptDalam = Department::firstOrCreate(['name' => 'Poliklinik Penyakit Dalam']);
        $deptBedah = Department::firstOrCreate(['name' => 'Poliklinik Bedah']);
        $deptLab   = Department::firstOrCreate(['name' => 'Laboratorium'], ['description' => 'Pelayanan laboratorium klinik.']);
        $deptAnak  = Department::firstOrCreate(['name' => 'Poliklinik Anak']);
        $deptRadio = Department::firstOrCreate(['name' => 'Radiologi'], ['description' => 'Pelayanan radiologi dan pencitraan medis.']);
        $deptKandungan = Department::firstOrCreate(['name' => 'Poliklinik Kandungan']);
        $deptOK = Department::firstOrCreate(['name' => 'Kamar Operasi (OK)'], ['description' => 'Instalasi Bedah Sentral / Kamar Operasi.']);

        // Jadwal Dinas 7x24 Jam (Senin - Minggu)
        $jadwal7x24 = [];
        for ($d = 1; $d <= 7; $d++) {
            $jadwal7x24[] = ['day' => $d, 'start' => '00:00', 'end' => '23:59'];
        }

        // ════════════════════════════════════════════════════════════════
        // Hapus data dokter yang salah nama (dari seeder sebelumnya)
        // ════════════════════════════════════════════════════════════════
        $wrongNames = [
            'dr. Moh. Darsan Ansari',
            'dr. Ayu Fitria Panuwa',
            'dr. Ivana Esther Baransano',
            'dr. Toti Reiner Cassardo',
            'dr. Nur Ragitta Lasena',
            'dr. Yessy Urulangon',
            'dr. Jacki L. Liow, Sp.A',
            'dr. Fini Olica Lalamu, Sp.PD',
            'dr. Fitri Olga Lalamu, Sp.PD',
            'dr. Muh. Rizki Ramdan Saezon, Sp.An',
            'dr. Ramna Audry Pinary, Sp.OG',
        ];
        foreach ($wrongNames as $wrongName) {
            $wrongDoctor = Doctor::where('name', $wrongName)->first();
            if ($wrongDoctor) {
                DoctorSchedule::where('doctor_id', $wrongDoctor->id)->delete();
                $wrongDoctor->forceDelete();
            }
        }

        // ════════════════════════════════════════════════════════════════
        // DATA DOKTER YANG BENAR DARI FOTO
        // ════════════════════════════════════════════════════════════════
        $doctorsData = [

            // ───────────── RUANGAN UGD ─────────────
            [
                'name' => 'dr. Moh. Dawam Ansori',
                'specialization' => 'Dokter Ahli Muda',
                'department_id' => $deptUGD->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => false, // TUGAS BELAJAR
                'schedules' => [],
            ],
            [
                'name' => 'dr. Ayu Fitria Panawar',
                'specialization' => 'Dokter Ahli Pertama',
                'department_id' => $deptUGD->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => true,
                'schedules' => $jadwal7x24,
            ],
            [
                'name' => 'dr. Ivana Esther Baharutan',
                'specialization' => 'Dokter Ahli Pertama',
                'department_id' => $deptUGD->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => true,
                'schedules' => $jadwal7x24,
            ],
            [
                'name' => 'dr. Polii Reiner Caesardo',
                'specialization' => 'Dokter Ahli Pertama',
                'department_id' => $deptUGD->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => true,
                'schedules' => $jadwal7x24,
            ],
            [
                'name' => 'dr. Sabriani Pontoh',
                'specialization' => 'Dokter Ahli Pertama',
                'department_id' => $deptUGD->id,
                'status_kepegawaian' => 'PPPK',
                'is_active' => true,
                'schedules' => [
                    ['day' => 1, 'start' => '07:45', 'end' => '16:30'],
                    ['day' => 2, 'start' => '07:45', 'end' => '16:30'],
                    ['day' => 3, 'start' => '07:45', 'end' => '16:30'],
                    ['day' => 4, 'start' => '07:45', 'end' => '16:30'],
                    ['day' => 5, 'start' => '06:30', 'end' => '11:30'],
                ],
            ],
            [
                'name' => 'dr. Christo F.N Bawelle',
                'specialization' => 'Dokter Umum',
                'department_id' => $deptUGD->id,
                'status_kepegawaian' => 'KONTRAK BLUD',
                'is_active' => true,
                'schedules' => $jadwal7x24,
            ],
            [
                'name' => 'dr. Nur Magfira Lasena',
                'specialization' => 'Dokter Umum',
                'department_id' => $deptUGD->id,
                'status_kepegawaian' => 'KONTRAK BLUD',
                'is_active' => true,
                'schedules' => $jadwal7x24,
            ],
            [
                'name' => 'dr. Teddy Unsulangi',
                'specialization' => 'Dokter Umum',
                'department_id' => $deptUGD->id,
                'status_kepegawaian' => 'KONTRAK BLUD',
                'is_active' => true,
                'schedules' => $jadwal7x24,
            ],

            // ───────────── RUANGAN INTERNE ─────────────
            [
                'name' => 'dr. Fitri Olga Latamu, Sp.PD',
                'specialization' => 'Dokter Spesialis Penyakit Dalam',
                'department_id' => $deptDalam->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => true,
                'schedules' => [
                    // RAWAT JALAN SENIN S/D RABU (08:00 S/D 14:00 WITA)
                    ['day' => 1, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 2, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 3, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 4, 'start' => '07:45', 'end' => '08:30'],
                    ['day' => 5, 'start' => '06:30', 'end' => '08:30'],
                ],
            ],

            // ───────────── RUANGAN BEDAH ─────────────
            [
                'name' => 'dr. Juwita D. Pratiwi, Sp.B',
                'specialization' => 'Dokter Spesialis Bedah',
                'department_id' => $deptBedah->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => true,
                'schedules' => [
                    // RAWAT JALAN SENIN S/D JUMAT (08:00 S/D 14:00 WITA)
                    ['day' => 1, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 2, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 3, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 4, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 5, 'start' => '08:00', 'end' => '11:00'],
                ],
            ],

            // ───────────── RUANGAN LABORATORIUM ─────────────
            [
                'name' => 'dr. Budi Parabang, Sp.PK',
                'specialization' => 'Dokter Spesialis Patologi Klinik',
                'department_id' => $deptLab->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => true,
                'schedules' => [
                    // RAWAT JALAN SENIN S/D JUMAT (08:00 S/D 14:00 WITA)
                    ['day' => 1, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 2, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 3, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 4, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 5, 'start' => '08:00', 'end' => '11:00'],
                ],
            ],

            // ───────────── RUANGAN ANAK ─────────────
            [
                'name' => 'dr. Jackli Liow, Sp.A',
                'specialization' => 'Dokter Spesialis Anak',
                'department_id' => $deptAnak->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => true,
                'schedules' => [
                    // RAWAT JALAN SENIN S/D JUMAT (08:00 S/D 14:00 WITA)
                    ['day' => 1, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 2, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 3, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 4, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 5, 'start' => '08:00', 'end' => '11:00'],
                ],
            ],

            // ───────────── RUANGAN RADIOLOGI ─────────────
            [
                'name' => 'dr. Teddy M. Herman, Sp.Rad',
                'specialization' => 'Dokter Spesialis Radiologi',
                'department_id' => $deptRadio->id,
                'status_kepegawaian' => 'KONTRAK BLUD',
                'is_active' => true,
                'schedules' => [
                    // RAWAT JALAN SENIN S/D JUMAT (08:00 S/D 14:00 WITA)
                    ['day' => 1, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 2, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 3, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 4, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 5, 'start' => '08:00', 'end' => '14:00'],
                ],
            ],

            // ───────────── RUANGAN PONEK (Kandungan) ─────────────
            [
                'name' => 'dr. Rahma Audry Fitriany, Sp. OG',
                'specialization' => 'Dokter Spesialis Obstetri & Ginekologi',
                'department_id' => $deptKandungan->id,
                'status_kepegawaian' => 'PNS',
                'is_active' => true,
                'schedules' => [
                    // RAWAT JALAN SENIN S/D RABU (08:00 S/D 14:00 WITA)
                    // RAWAT INAP 7 X 24 JAM
                    ['day' => 1, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 2, 'start' => '08:00', 'end' => '14:00'],
                    ['day' => 3, 'start' => '08:00', 'end' => '14:00'],
                ],
            ],

            // ───────────── RUANGAN OK (Kamar Operasi) ─────────────
            [
                'name' => 'dr. Muh. Rizki Ramdan Sarson, Sp.An',
                'specialization' => 'Dokter Spesialis Anestesi',
                'department_id' => $deptOK->id,
                'status_kepegawaian' => 'KONTRAK BLUD',
                'is_active' => true,
                'schedules' => [
                    // SENIN S/D SELASA (2X24 JAM)
                    ['day' => 1, 'start' => '00:00', 'end' => '23:59'],
                    ['day' => 2, 'start' => '00:00', 'end' => '23:59'],
                ],
            ],
        ];

        foreach ($doctorsData as $data) {
            $doctor = Doctor::where('name', $data['name'])->first();

            if (!$doctor) {
                $email = strtolower(str_replace([' ', ',', '.'], '', $data['name'])) . '@rsud.com';
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $data['name'],
                        'password' => Hash::make('password123'),
                        'role' => 'doctor',
                    ]
                );

                $doctor = Doctor::create([
                    'user_id'        => $user->id,
                    'department_id'  => $data['department_id'],
                    'name'           => $data['name'],
                    'specialization' => $data['specialization'],
                    'phone'          => '08' . rand(1000000000, 9999999999),
                    'email'          => $email,
                    'is_active'      => $data['is_active'],
                    'notes'          => $data['status_kepegawaian'],
                ]);
            } else {
                $doctor->update([
                    'department_id'  => $data['department_id'],
                    'specialization' => $data['specialization'],
                    'is_active'      => $data['is_active'],
                    'notes'          => $data['status_kepegawaian'],
                ]);
            }

            // Reset jadwal lama, lalu masukkan jadwal baru
            DoctorSchedule::where('doctor_id', $doctor->id)->delete();

            foreach ($data['schedules'] as $schedule) {
                DoctorSchedule::create([
                    'doctor_id'   => $doctor->id,
                    'day_of_week' => $schedule['day'],
                    'start_time'  => $schedule['start'],
                    'end_time'    => $schedule['end'],
                    'max_patients'=> 20,
                    'is_active'   => true,
                ]);
            }
        }
    }
}
