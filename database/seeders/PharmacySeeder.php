<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Suppliers
        $suppliers = [
            [
                'code' => 'SUP001',
                'name' => 'PT. Pharma Indonesia',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'phone' => '021-123456',
                'email' => 'info@pharma.com',
                'contact_person' => 'Budi Santoso',
            ],
            [
                'code' => 'SUP002',
                'name' => 'CV. Medika Jaya',
                'address' => 'Jl. Ahmad Yani No. 45, Surabaya',
                'phone' => '031-234567',
                'email' => 'cs@medika.com',
                'contact_person' => 'Siti Nurhaliza',
            ],
            [
                'code' => 'SUP003',
                'name' => 'PT. Kesehatan Mandiri',
                'address' => 'Jl. Sudirman No. 67, Bandung',
                'phone' => '022-345678',
                'email' => 'sales@kesehatan.com',
                'contact_person' => 'Ahmad Wijaya',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(['code' => $supplier['code']], $supplier);
        }

        // Create Medicines
        $medicines = [
            [
                'code' => 'OBT001',
                'name' => 'Paracetamol 500mg',
                'unit' => 'TABLET',
                'price' => 2500,
                'description' => 'Obat penurun demam dan nyeri',
            ],
            [
                'code' => 'OBT002',
                'name' => 'Amoxicillin 500mg',
                'unit' => 'KAPSUL',
                'price' => 5000,
                'description' => 'Antibiotic untuk infeksi',
            ],
            [
                'code' => 'OBT003',
                'name' => 'Vitamin C 1000mg',
                'unit' => 'TABLET',
                'price' => 15000,
                'description' => 'Vitamin C untuk daya tahan tubuh',
            ],
            [
                'code' => 'OBT004',
                'name' => 'Ibuprofen 200mg',
                'unit' => 'TABLET',
                'price' => 3000,
                'description' => 'Obat anti-inflamasi',
            ],
            [
                'code' => 'OBT005',
                'name' => 'Antacida',
                'unit' => 'TABLET',
                'price' => 2000,
                'description' => 'Untuk masalah pencernaan',
            ],
            [
                'code' => 'OBT006',
                'name' => 'Chlorpheniramine 2mg',
                'unit' => 'TABLET',
                'price' => 1500,
                'description' => 'Antihistamin untuk alergi',
            ],
            [
                'code' => 'OBT007',
                'name' => 'Metformin 500mg',
                'unit' => 'TABLET',
                'price' => 8000,
                'description' => 'Untuk diabetes tipe 2',
            ],
            [
                'code' => 'OBT008',
                'name' => 'Omeprazole 20mg',
                'unit' => 'KAPSUL',
                'price' => 12000,
                'description' => 'Untuk asam lambung',
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::updateOrCreate(['code' => $medicine['code']], $medicine);
        }
    }
}
