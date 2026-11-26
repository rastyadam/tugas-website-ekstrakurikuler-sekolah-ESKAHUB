
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('persyaratan', function (Blueprint $table) {

            if (!Schema::hasColumn('persyaratan', 'ekstrakurikuler_id')) {
                $table->foreignId('ekstrakurikuler_id')
                    ->nullable()
                    ->constrained('ekstrakurikuler')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('persyaratan', 'jenis_input')) {
                $table->enum('jenis_input', ['teks', 'berkas'])
                    ->default('teks');
            }

        });
    }

    public function down(): void
    {
        Schema::table('persyaratan', function (Blueprint $table) {

            if (Schema::hasColumn('persyaratan', 'jenis_input')) {
                $table->dropColumn('jenis_input');
            }

            // Jangan hapus ekstrakurikuler_id di sini
            // karena kolom tersebut sudah ada sebelumnya.
        });
    }
};
