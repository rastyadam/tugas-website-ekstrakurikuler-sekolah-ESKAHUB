<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah ENUM peran agar menerima 'pembina'
        DB::statement("ALTER TABLE pengguna MODIFY COLUMN peran ENUM('admin', 'siswa', 'pembina') NOT NULL DEFAULT 'siswa'");
    }

    public function down(): void
    {
        // Kembalikan ke semula jika di-rollback
        DB::statement("ALTER TABLE pengguna MODIFY COLUMN peran ENUM('admin', 'siswa') NOT NULL DEFAULT 'siswa'");
    }
};