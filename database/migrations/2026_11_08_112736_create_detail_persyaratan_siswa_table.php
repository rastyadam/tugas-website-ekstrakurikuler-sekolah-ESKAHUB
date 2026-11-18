<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_persyaratan_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persyaratan_id')->constrained('persyaratan')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta_pendaftaran')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('member_siswa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_persyaratan_siswa');
    }
};