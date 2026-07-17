<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel tagihan/pembayaran pasien.
     * Setiap registrasi menghasilkan satu tagihan.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();

            // Nomor invoice: INV-2026-0001
            $table->string('invoice_number', 30)->unique();

            $table->decimal('total_amount', 12, 2)->default(0);

            // Metode pembayaran
            $table->enum('payment_method', ['cash', 'bpjs', 'insurance', 'transfer', 'debit', 'credit'])
                  ->default('cash');

            // Status pembayaran
            $table->enum('status', ['pending', 'paid', 'partial', 'cancelled'])
                  ->default('pending');

            // Waktu pembayaran dilakukan
            $table->timestamp('paid_at')->nullable();

            // Siapa yang memproses pembayaran
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
