<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom lengkap ke tabel doctors:
     * user_id, employee_code, email, photo, str_number, sip_number, is_active, notes
     * Rename: specialist → specialization (jika belum)
     */
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            // Relasi ke user
            if (!Schema::hasColumn('doctors', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->after('id');
            }
            // Kode pegawai: DOK-001
            if (!Schema::hasColumn('doctors', 'employee_code')) {
                $table->string('employee_code', 20)->unique()->nullable()->after('user_id');
            }
            // Spesialisasi — tambah kolom specialization, copy dari specialist jika ada
            if (!Schema::hasColumn('doctors', 'specialization')) {
                $table->string('specialization')->nullable()->after('name');
            }
            // Email dokter
            if (!Schema::hasColumn('doctors', 'email')) {
                $table->string('email')->nullable()->after('phone');
            }
            // Nomor STR (Surat Tanda Registrasi)
            if (!Schema::hasColumn('doctors', 'str_number')) {
                $table->string('str_number', 50)->nullable()->after('email');
            }
            // Nomor SIP (Surat Izin Praktik)
            if (!Schema::hasColumn('doctors', 'sip_number')) {
                $table->string('sip_number', 50)->nullable()->after('str_number');
            }
            // Foto dokter
            if (!Schema::hasColumn('doctors', 'photo')) {
                $table->string('photo')->nullable()->after('sip_number');
            }
            // Status aktif
            if (!Schema::hasColumn('doctors', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('photo');
            }
            // Catatan / bio
            if (!Schema::hasColumn('doctors', 'notes')) {
                $table->text('notes')->nullable()->after('is_active');
            }
        });

        // Copy data dari kolom 'specialist' ke 'specialization' jika kolom lama masih ada
        if (Schema::hasColumn('doctors', 'specialist') && Schema::hasColumn('doctors', 'specialization')) {
            \Illuminate\Support\Facades\DB::statement(
                'UPDATE doctors SET specialization = specialist WHERE specialization IS NULL'
            );
        }
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $cols = ['user_id', 'employee_code', 'email', 'str_number', 'sip_number', 'photo', 'is_active', 'notes'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('doctors', $col)) {
                    if ($col === 'user_id') $table->dropForeign(['user_id']);
                    $table->dropColumn($col);
                }
            }
        });
    }
};
