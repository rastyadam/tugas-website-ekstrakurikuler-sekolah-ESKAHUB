<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gelombang_id')->constrained('gelombang_pendaftaran')->onDelete('cascade');
            $table->string('nisn', 10)->nullable();
            $table->string('nama');
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_daftar')->nullable();
            $table->string('alokasi', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_pendaftaran');
    }
};