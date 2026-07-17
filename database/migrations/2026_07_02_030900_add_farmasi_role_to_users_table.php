<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Menambahkan role 'farmasi' (Apoteker) ke kolom ENUM role di tabel users.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'doctor', 'petugas', 'patient', 'kasir', 'super_admin', 'farmasi') NOT NULL DEFAULT 'petugas'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'doctor', 'petugas', 'patient', 'kasir', 'super_admin') NOT NULL DEFAULT 'petugas'");
    }
};
