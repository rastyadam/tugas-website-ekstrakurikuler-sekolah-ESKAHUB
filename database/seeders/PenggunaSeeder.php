<?php

namespace Database\Seeders;

use App\Models\pengguna;
use App\Models\MemberSiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // ================= ADMIN =================
        Pengguna::create([
            'nama'        => 'Administrator',
            'email'       => 'admin@eskahub.sch.id',
            'username'    => 'admin',
            'kata_sandi'  => Hash::make('password123'),
            'peran'       => 'admin',
        ]);

        // ================= SISWA =================
        $siswa1 = Pengguna::create([
            'nama'        => 'ARINI TYAS',
            'email'       => 'AriniTyas@siswa.smkhebat.sch.id',
            'username'    => '0058492018',
            'kata_sandi'  => Hash::make('password123'),
            'peran'       => 'siswa',
        ]);

        MemberSiswa::create([
            'pengguna_id'    => $siswa1->id,
            'nisn'           => '0058492018',
            'nama'           => 'ARINI TYAS',
            'jenis_kelamin'  => 'P',
            'email'          => 'AriniTyas@siswa.smkhebat.sch.id',
            'no_hp'          => '081234567890',
            'alamat'         => 'Jl. Pendidikan No. 1, Malang',
            'kelas'          => 'X RPL 1',
            'jurusan'        => 'REKAYASA PERANGKAT LUNAK',
        ]);

        // Siswa contoh kedua (opsional)
        $siswa2 = Pengguna::create([
            'nama'        => 'BUDI SANTOSO',
            'email'       => 'BudiSantoso@siswa.smkhebat.sch.id',
            'username'    => '0061234567',
            'kata_sandi'  => Hash::make('password123'),
            'peran'       => 'siswa',
        ]);

        MemberSiswa::create([
            'pengguna_id'    => $siswa2->id,
            'nisn'           => '0061234567',
            'nama'           => 'BUDI SANTOSO',
            'jenis_kelamin'  => 'L',
            'email'          => 'BudiSantoso@siswa.smkhebat.sch.id',
            'no_hp'          => '081298765432',
            'alamat'         => 'Jl. Merdeka No. 10, Malang',
            'kelas'          => 'XI TKJ 2',
            'jurusan'        => 'TEKNIK KOMPUTER DAN JARINGAN',
        ]);
    }
}