<?php

namespace Database\Seeders;

use App\Models\Registration;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DemoRegistrationSeeder extends Seeder
{
    /**
     * Buat data pendaftaran demo untuk 7 hari terakhir
     * sehingga grafik di dashboard bisa menampilkan data.
     */
    public function run(): void
    {
        $patient    = Patient::first();
        $doctor     = Doctor::first();
        $department = Department::first();

        if (!$patient || !$doctor || !$department) {
            $this->command->warn('⚠️  DemoRegistrationSeeder: Tidak ada data patient/doctor/department. Lewati.');
            return;
        }

        // Hapus data lama agar tidak duplikasi (menggunakan delete agar cascade ke tabel relasi)
        Registration::query()->delete();

        $totalCreated = 0;

        // Generate data untuk 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();

            // Jumlah pendaftaran per hari (bervariasi agar grafik menarik)
            $dailyCounts = [3, 7, 5, 12, 9, 15, 6];
            $count = $dailyCounts[$i] ?? rand(3, 15);

            for ($j = 0; $j < $count; $j++) {
                Registration::create([
                    'patient_id'        => $patient->id,
                    'doctor_id'         => $doctor->id,
                    'department_id'     => $department->id,
                    'registration_date' => $date,
                    'created_at'        => Carbon::parse($date)->addHours(rand(7, 17)),
                    'updated_at'        => Carbon::parse($date)->addHours(rand(7, 17)),
                ]);
                $totalCreated++;
            }
        }

        $this->command->info("✅ DemoRegistrationSeeder: {$totalCreated} data pendaftaran dibuat untuk 7 hari terakhir.");
    }
}
