<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GelombangPendaftaran; // Pastikan modelnya ada

class GelombangPendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        GelombangPendaftaran::create([
            'nama' => 'Gelombang 1',
            'status' => 'aktif',
            'tanggal_mulai' => '2026-11-01',
            'tanggal_selesai' => '2026-12-31',
        ]);
    }
}