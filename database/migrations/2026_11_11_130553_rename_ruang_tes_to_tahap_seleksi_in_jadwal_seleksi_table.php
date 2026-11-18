<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_seleksi', function (Blueprint $table) {
            // Rename kolom ruang_tes jadi tahap_seleksi
            $table->renameColumn('ruang_tes', 'tahap_seleksi');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_seleksi', function (Blueprint $table) {
            // Balikin lagi kalau di-rollback
            $table->renameColumn('tahap_seleksi', 'ruang_tes');
        });
    }
};