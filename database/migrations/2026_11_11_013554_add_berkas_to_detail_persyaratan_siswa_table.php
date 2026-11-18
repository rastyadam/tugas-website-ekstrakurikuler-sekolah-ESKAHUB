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
        Schema::table('detail_persyaratan_siswa', function (Blueprint $table) {
            // ✅ Tambahkan kolom berkas setelah member_id
            $table->string('berkas')->nullable()->after('member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_persyaratan_siswa', function (Blueprint $table) {
            $table->dropColumn('berkas');
        });
    }
};