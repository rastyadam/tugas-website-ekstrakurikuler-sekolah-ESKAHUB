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
        Schema::create('pembina', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel pengguna (karena pembina juga butuh akun untuk login)
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');
            
            $table->string('nama');
            $table->string('jenis_pembina')->nullable(); // Misal: 'Internal', 'Eksternal'
            $table->string('no_hp', 20)->nullable();
            $table->string('asal')->nullable(); // Misal: 'SMKN 1 Purwosari' atau 'Klub Basket'
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembina');
    }
};