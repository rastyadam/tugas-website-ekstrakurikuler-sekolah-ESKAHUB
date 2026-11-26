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
    Schema::table('persyaratan', function (Blueprint $table) {
        $table->foreignId('ekstrakurikuler_id')
            ->nullable()
            ->after('id')
            ->constrained('ekstrakurikuler')
            ->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::table('persyaratan', function (Blueprint $table) {
        $table->dropForeign(['ekstrakurikuler_id']);
        $table->dropColumn('ekstrakurikuler_id');
    });
}

};
