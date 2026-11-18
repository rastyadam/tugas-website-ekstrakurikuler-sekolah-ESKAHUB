<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persyaratan;

class PersyaratanSeeder extends Seeder
{
    public function run(): void
    {
        Persyaratan::create([
            'nama' => 'Kartu Pelajar',
            'tipe_persyaratan' => 'Dokumen',
            'status' => 'wajib',
        ]);

        Persyaratan::create([
            'nama' => 'Pas Foto 3x4',
            'tipe_persyaratan' => 'Gambar',
            'status' => 'wajib',
        ]);
    }
}