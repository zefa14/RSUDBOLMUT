<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom tarif konsultasi per dokter dan per departemen/poli.
     * Ini memungkinkan tarif yang berbeda-beda untuk setiap dokter dan setiap poli.
     */
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->decimal('consultation_fee', 12, 2)->nullable()->after('phone')
                  ->comment('Tarif konsultasi khusus dokter ini (opsional, override tarif poli)');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->decimal('consultation_fee', 12, 2)->nullable()->after('name')
                  ->comment('Tarif konsultasi default untuk poli ini');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('consultation_fee');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('consultation_fee');
        });
    }
};
