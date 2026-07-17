<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class RealRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all inpatients first to avoid foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('inpatients')->truncate();
        DB::table('rooms')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rooms = [
            // Gedung 4 Lantai
            // Lantai 3
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 3', 'room_class' => 'Kelas VIP', 'name' => 'Anggrek 1', 'total_beds' => 1],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 3', 'room_class' => 'Kelas VIP', 'name' => 'Anggrek 2', 'total_beds' => 1],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 3', 'room_class' => 'Kelas I', 'name' => 'Flamboyan 1', 'total_beds' => 2],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 3', 'room_class' => 'Kelas I', 'name' => 'Flamboyan 2', 'total_beds' => 2],
            
            // Lantai 2
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 2', 'room_class' => 'Kelas III', 'name' => 'Tulip 1', 'total_beds' => 4],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 2', 'room_class' => 'Kelas III', 'name' => 'Tulip 2', 'total_beds' => 4],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 2', 'room_class' => 'Kelas II', 'name' => 'Lily', 'total_beds' => 3],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 2', 'room_class' => 'Kelas I', 'name' => 'Sakura 1', 'total_beds' => 2],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 2', 'room_class' => 'Kelas I', 'name' => 'Sakura 2', 'total_beds' => 2],

            // Lantai 1
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 1', 'room_class' => 'Kelas III', 'name' => 'Bougenville 1', 'total_beds' => 4],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 1', 'room_class' => 'Kelas III', 'name' => 'Bougenville 2', 'total_beds' => 4],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 1', 'room_class' => 'Kelas III', 'name' => 'Raflesia', 'total_beds' => 4],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 1', 'room_class' => 'Kelas III', 'name' => 'Ruangan Immunocompromised', 'total_beds' => 4],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 1', 'room_class' => 'Kelas II', 'name' => 'Teratai 1', 'total_beds' => 4],
            ['building' => 'Gedung 4 Lantai', 'floor' => 'Lantai 1', 'room_class' => 'Kelas II', 'name' => 'Teratai 2', 'total_beds' => 4],

            // Gedung Rawat Inap Bedah
            ['building' => 'Gedung Rawat Inap Bedah', 'floor' => '-', 'room_class' => 'Kelas III', 'name' => 'Dahlia 1', 'total_beds' => 4],
            ['building' => 'Gedung Rawat Inap Bedah', 'floor' => '-', 'room_class' => 'Kelas III', 'name' => 'Dahlia 2', 'total_beds' => 4],
            ['building' => 'Gedung Rawat Inap Bedah', 'floor' => '-', 'room_class' => 'Kelas II', 'name' => 'Melati', 'total_beds' => 4],
            ['building' => 'Gedung Rawat Inap Bedah', 'floor' => '-', 'room_class' => 'Kelas I', 'name' => 'Mawar', 'total_beds' => 2],

            // Gedung Isolasi
            ['building' => 'Gedung Isolasi', 'floor' => '-', 'room_class' => 'Kelas I', 'name' => 'Cendrawasih', 'total_beds' => 1],
            ['building' => 'Gedung Isolasi', 'floor' => '-', 'room_class' => 'Kelas II', 'name' => 'Maleo', 'total_beds' => 2],
            ['building' => 'Gedung Isolasi', 'floor' => '-', 'room_class' => 'Kelas III', 'name' => 'Merak 1', 'total_beds' => 2],
            ['building' => 'Gedung Isolasi', 'floor' => '-', 'room_class' => 'Kelas III', 'name' => 'Merak 2', 'total_beds' => 2],
            ['building' => 'Gedung Isolasi', 'floor' => '-', 'room_class' => 'Suspect / Non Kelas', 'name' => 'Merpati', 'total_beds' => 2],

            // Gedung PONEK
            // Lantai 2
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas III', 'name' => 'Lavender 1', 'total_beds' => 4],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas III', 'name' => 'Lavender 2', 'total_beds' => 4],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas III', 'name' => 'Lavender 3', 'total_beds' => 3],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas III', 'name' => 'Lavender 4', 'total_beds' => 2],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas III', 'name' => 'Lavender 5', 'total_beds' => 2],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas II', 'name' => 'Asoka 1', 'total_beds' => 2],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas II', 'name' => 'Asoka 2', 'total_beds' => 2],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas I', 'name' => 'Edelweis 1', 'total_beds' => 1],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas I', 'name' => 'Edelweis 2', 'total_beds' => 1],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Kelas I', 'name' => 'Edelweis 3', 'total_beds' => 1],
            ['building' => 'Gedung PONEK', 'floor' => 'Lantai 2', 'room_class' => 'Non Kelas', 'name' => 'Ruangan NICU', 'total_beds' => 4],
        ];

        foreach ($rooms as $room) {
            Room::create([
                'building' => $room['building'],
                'floor' => $room['floor'],
                'room_class' => $room['room_class'],
                'name' => $room['name'],
                'total_beds' => $room['total_beds'],
                'occupied_beds' => 0,
            ]);
        }
    }
}
