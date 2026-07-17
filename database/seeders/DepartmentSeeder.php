<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Poliklinik Umum', 'description' => 'Pelayanan medis dasar dan pemeriksaan kesehatan umum.'],
            ['name' => 'Poliklinik Gigi', 'description' => 'Pelayanan kesehatan gigi dan mulut.'],
            ['name' => 'Poliklinik Penyakit Dalam', 'description' => 'Pemeriksaan dan penanganan penyakit organ dalam.'],
            ['name' => 'Poliklinik Anak', 'description' => 'Pelayanan kesehatan khusus bayi, anak, dan remaja.'],
            ['name' => 'Poliklinik Kandungan', 'description' => 'Pelayanan kesehatan ibu hamil dan kandungan (Obgyn).'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], $dept);
        }
    }
}
