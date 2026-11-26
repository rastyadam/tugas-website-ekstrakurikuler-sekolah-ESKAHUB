<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            // Tambah kolom jadwal
            $table->string('hari')->nullable()->after('deskripsi');
            $table->date('tanggal_mulai')->nullable()->after('hari');
            $table->time('jam_mulai')->nullable()->after('tanggal_mulai');
            $table->time('jam_selesai')->nullable()->after('jam_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->dropColumn(['hari', 'tanggal_mulai', 'jam_mulai', 'jam_selesai']);
        });
    }
};