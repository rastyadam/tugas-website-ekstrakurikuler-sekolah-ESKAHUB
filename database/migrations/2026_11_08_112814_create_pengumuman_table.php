<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta_pendaftaran')->onDelete('cascade');
            $table->text('alasan_penolakan')->nullable();
            $table->enum('status', ['Lulus', 'Tidak Lulus', 'Pending'])->default('Pending');
            $table->date('tanggal_daftar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};