<?php

namespace Database\Seeders;

use App\Models\MedicineCategory;
use Illuminate\Database\Seeder;

class MedicineCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['code' => 'ANT', 'name' => 'Antibiotik', 'description' => 'Obat untuk mengatasi infeksi bakteri.'],
            ['code' => 'ALG', 'name' => 'Analgesik', 'description' => 'Obat pereda nyeri.'],
            ['code' => 'VIT', 'name' => 'Vitamin & Suplemen', 'description' => 'Membantu menjaga dan memulihkan daya tahan tubuh.'],
            ['code' => 'PNC', 'name' => 'Pencernaan', 'description' => 'Obat untuk masalah lambung dan pencernaan.'],
            ['code' => 'PRN', 'name' => 'Pernapasan', 'description' => 'Obat untuk asma, batuk, dan masalah pernapasan lainnya.'],
        ];

        foreach ($categories as $cat) {
            MedicineCategory::firstOrCreate(['code' => $cat['code']], $cat);
        }
    }
}
