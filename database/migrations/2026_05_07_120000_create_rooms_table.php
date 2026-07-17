<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Bangsal/Ruang (Mawar, Melati)
            $table->string('room_class'); // Kelas (VVIP, VIP, Kelas I, IGD)
            $table->integer('total_beds')->default(0); // Kapasitas Maksimal
            $table->integer('occupied_beds')->default(0); // Kasur Terisi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
