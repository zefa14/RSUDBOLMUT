<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom ward_id ke tabel rooms agar setiap kamar terhubung langsung ke bangsal induknya.
     * Ini memungkinkan Super Admin mengelola semua kamar dari halaman Master Bangsal.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('ward_id')->nullable()->after('id');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });

        // Coba hubungkan room yang sudah ada dengan ward yang sesuai berdasarkan nama
        $rooms = \App\Models\Room::all();
        foreach ($rooms as $room) {
            $ward = \App\Models\Ward::where('name', $room->name)
                ->where('building', $room->building)
                ->first();
            if ($ward) {
                $room->update(['ward_id' => $ward->id]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['ward_id']);
            $table->dropColumn('ward_id');
        });
    }
};
