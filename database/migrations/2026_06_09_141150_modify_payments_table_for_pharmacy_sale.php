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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('registration_id')->nullable()->change();
            $table->foreign('registration_id')->references('id')->on('registrations')->cascadeOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->string('customer_name')->nullable();
            $table->enum('payment_type', ['registration', 'pharmacy_sale', 'other'])->default('registration')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn('patient_id');
            $table->dropColumn('customer_name');
            $table->dropColumn('payment_type');
            
            $table->dropForeign(['registration_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('registration_id')->nullable(false)->change();
            $table->foreign('registration_id')->references('id')->on('registrations')->cascadeOnDelete();
        });
    }
};
