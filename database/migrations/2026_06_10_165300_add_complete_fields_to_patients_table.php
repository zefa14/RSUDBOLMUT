<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Data Pribadi Tambahan
            $table->string('birth_place')->nullable()->after('birth_date');
            $table->string('religion')->nullable()->after('gender');
            $table->string('marital_status')->nullable()->after('religion');
            $table->string('education')->nullable()->after('marital_status');
            $table->string('occupation')->nullable()->after('education');

            // Alamat Lengkap
            $table->string('rt_rw')->nullable()->after('address');
            $table->string('kelurahan')->nullable()->after('rt_rw');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kabupaten')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kabupaten');
            $table->string('postal_code')->nullable()->after('provinsi');

            // Kontak Darurat
            $table->string('emergency_contact_name')->nullable()->after('email');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_relation')->nullable()->after('emergency_contact_phone');

            // Data Medis Dasar
            $table->text('allergy_notes')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'birth_place', 'religion', 'marital_status', 'education', 'occupation',
                'rt_rw', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'postal_code',
                'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relation',
                'allergy_notes',
            ]);
        });
    }
};
