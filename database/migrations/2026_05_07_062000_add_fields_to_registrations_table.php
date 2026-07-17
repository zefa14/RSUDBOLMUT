<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Nomor Antrian
            if (!Schema::hasColumn('registrations', 'queue_number')) {
                $table->string('queue_number', 10)->nullable()->after('department_id');
            }
            
            // Status pendaftaran
            if (!Schema::hasColumn('registrations', 'status')) {
                $table->enum('status', ['waiting', 'serving', 'done', 'cancelled'])
                      ->default('waiting')
                      ->after('registration_date');
            }
            
            // Keluhan pasien
            if (!Schema::hasColumn('registrations', 'complaint')) {
                $table->text('complaint')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $cols = ['queue_number', 'status', 'complaint'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('registrations', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
