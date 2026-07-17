<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Jenis Kunjungan: baru, lama, kontrol
            if (!Schema::hasColumn('registrations', 'visit_type')) {
                $table->string('visit_type', 20)->default('baru')->after('registration_date');
            }
            // Kelas BPJS: 1, 2, 3
            if (!Schema::hasColumn('registrations', 'bpjs_class')) {
                $table->string('bpjs_class', 5)->nullable()->after('referral_file_path');
            }
            // Nomor SEP (Surat Eligibilitas Peserta)
            if (!Schema::hasColumn('registrations', 'sep_number')) {
                $table->string('sep_number', 50)->nullable()->after('bpjs_class');
            }
            // Faskes / Klinik Perujuk
            if (!Schema::hasColumn('registrations', 'referral_origin')) {
                $table->string('referral_origin')->nullable()->after('sep_number');
            }
            // Diagnosa Awal
            if (!Schema::hasColumn('registrations', 'initial_diagnosis')) {
                $table->text('initial_diagnosis')->nullable()->after('complaint');
            }
            // Catatan internal petugas pendaftaran
            if (!Schema::hasColumn('registrations', 'registration_notes')) {
                $table->text('registration_notes')->nullable()->after('initial_diagnosis');
            }
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $cols = ['visit_type', 'bpjs_class', 'sep_number', 'referral_origin', 'initial_diagnosis', 'registration_notes'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('registrations', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
