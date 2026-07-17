<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            
            // Siapa yang melakukan aktivitas
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Jenis aksi: login, create_patient, update_registration, dll
            $table->string('action');
            
            // Deskripsi lengkap aktivitas
            $table->string('description');
            
            // Referensi model yang diubah (polymorphic) opsional
            $table->nullableMorphs('subject');
            
            // IP address dan user agent
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
