<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom lengkap ke tabel patients:
     * patient_code, bpjs_number, blood_type, photo, is_active
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Kode pasien otomatis: RSU-2026-0001
            if (!Schema::hasColumn('patients', 'patient_code')) {
                $table->string('patient_code', 20)->unique()->nullable()->after('id');
            }
            // BPJS
            if (!Schema::hasColumn('patients', 'bpjs_number')) {
                $table->string('bpjs_number', 20)->nullable()->after('nik');
            }
            // Golongan darah
            if (!Schema::hasColumn('patients', 'blood_type')) {
                $table->enum('blood_type', ['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])
                      ->nullable()->after('bpjs_number');
            }
            // Email pasien
            if (!Schema::hasColumn('patients', 'email')) {
                $table->string('email')->nullable()->after('phone');
            }
            // Foto pasien
            if (!Schema::hasColumn('patients', 'photo')) {
                $table->string('photo')->nullable()->after('email');
            }
            // Status aktif
            if (!Schema::hasColumn('patients', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('photo');
            }
            // Relasi ke user (opsional jika pasien punya akun)
            if (!Schema::hasColumn('patients', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->after('is_active');
            }
            // Catatan
            if (!Schema::hasColumn('patients', 'notes')) {
                $table->text('notes')->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $cols = ['patient_code', 'bpjs_number', 'blood_type', 'email', 'photo', 'is_active', 'user_id', 'notes'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('patients', $col)) {
                    if ($col === 'user_id') $table->dropForeign(['user_id']);
                    $table->dropColumn($col);
                }
            }
        });
    }
};
