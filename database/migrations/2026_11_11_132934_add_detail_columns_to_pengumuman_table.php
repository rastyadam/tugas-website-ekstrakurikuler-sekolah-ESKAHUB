<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            // Kita ubah peserta_id jadi nullable (karena pengumuman umum nggak butuh peserta)
            $table->foreignId('peserta_id')->nullable()->change();
            
            // Tambah kolom untuk info umum
            $table->foreignId('ekstrakurikuler_id')->nullable()->constrained('ekstrakurikuler')->onDelete('cascade');
            $table->string('judul')->nullable();
            $table->text('isi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->dropForeign(['ekstrakurikuler_id']);
            $table->dropColumn(['ekstrakurikuler_id', 'judul', 'isi']);
            $table->foreignId('peserta_id')->nullable(false)->change();
        });
    }
};