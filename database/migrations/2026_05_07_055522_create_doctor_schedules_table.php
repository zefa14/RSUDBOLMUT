<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel jadwal praktik dokter per hari.
     * Setiap dokter bisa punya banyak jadwal (Senin-Minggu).
     */
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();

            // Hari: 1=Senin, 2=Selasa, ..., 7=Minggu
            $table->tinyInteger('day_of_week')->comment('1=Senin, 7=Minggu');
            $table->time('start_time');
            $table->time('end_time');

            // Kuota maksimal pasien per sesi
            $table->unsignedSmallInteger('max_patients')->default(20);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
