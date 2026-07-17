<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Buat user demo untuk semua role.
     * Password semua: password123
     */
    public function run(): void
    {
        $users = [
            [
                'name'      => 'Administrator RSUD',
                'email'     => 'admin@rsud.com',
                'password'  => Hash::make('password123'),
                'role'      => 'admin',
                'phone'     => '081234567890',
                'is_active' => true,
            ],
            [
                'name'      => 'Dr. Ahmad Fauzan, Sp.PD',
                'email'     => 'dokter@rsud.com',
                'password'  => Hash::make('password123'),
                'role'      => 'doctor',
                'phone'     => '081234567891',
                'is_active' => true,
            ],
            [
                'name'      => 'Budi Santoso',
                'email'     => 'petugas@rsud.com',
                'password'  => Hash::make('password123'),
                'role'      => 'petugas',
                'phone'     => '081234567892',
                'is_active' => true,
            ],
            [
                'name'      => 'Siti Aminah',
                'email'     => 'pasien@rsud.com',
                'password'  => Hash::make('password123'),
                'role'      => 'patient',
                'phone'     => '081234567893',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            // Gunakan updateOrCreate agar tidak duplikasi jika dijalankan ulang
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('✅ UserSeeder: 4 user demo berhasil dibuat.');
        $this->command->info('   • admin@rsud.com     → password123 (Admin)');
        $this->command->info('   • dokter@rsud.com    → password123 (Dokter)');
        $this->command->info('   • petugas@rsud.com   → password123 (Petugas)');
        $this->command->info('   • pasien@rsud.com    → password123 (Pasien)');
    }
}
