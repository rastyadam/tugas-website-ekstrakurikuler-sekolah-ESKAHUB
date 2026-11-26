
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_persyaratan_siswa', function (Blueprint $table) {
            $table->text('isi_jawaban')->nullable();

            $table->string('berkas_siswa')->nullable();

            $table->enum('status_verifikasi', [
                'menunggu',
                'diterima',
                'ditolak'
            ])->default('menunggu');

            $table->text('catatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('detail_persyaratan_siswa', function (Blueprint $table) {
            $table->dropColumn([
                'isi_jawaban',
                'berkas_siswa',
                'status_verifikasi',
                'catatan',
            ]);
        });
    }
};
