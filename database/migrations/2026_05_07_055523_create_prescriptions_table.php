<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel resep obat yang terhubung ke rekam medis.
     * Setiap rekam medis bisa punya banyak resep obat.
     */
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();

            // Jumlah obat yang diresepkan
            $table->unsignedInteger('quantity');

            // Dosis: "3x1 tablet", "2x sehari"
            $table->string('dosage');

            // Instruksi: "Setelah makan", "Sebelum tidur"
            $table->string('instructions')->nullable();

            // Catatan apoteker
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
