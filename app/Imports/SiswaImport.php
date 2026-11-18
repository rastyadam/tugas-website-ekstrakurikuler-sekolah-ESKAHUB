<?php

namespace App\Imports;

use App\Models\Pengguna;
use App\Models\MemberSiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow; // ✅ Import ini
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SiswaImport implements ToModel, WithHeadingRow, WithStartRow // ✅ Tambahkan WithStartRow di sini
{
    // ✅ Fungsi startRow buat nentuin mulai baris ke berapa
    public function startRow(): int
    {
        return 1;
    }

    public function model(array $row): ?Model
    {

      \Log::info('Isi Baris Excel:', $row);
        // Cek NISN biar nggak dobel
        $exists = MemberSiswa::where('nisn', $row['nisn'])->exists();
        if ($exists) {
            return null; 
        }

        return DB::transaction(function () use ($row) {
            // 1. Buat Akun Pengguna
            $pengguna = Pengguna::create([
                'nama' => $row['nama'],
                'email' => $row['email'],
                'username' => $row['nisn'],
                'kata_sandi' => Hash::make('password123'), // Password default
                'peran' => 'siswa',
                'harus_ganti_password' => true,
            ]);

            // 2. Buat Profil Siswa
            return new MemberSiswa([
                'pengguna_id' => $pengguna->id,
                'nisn' => $row['nisn'],
                'nama' => $row['nama'],
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'email' => $row['email'],
                'no_hp' => $row['no_hp'] ?? null,
                'kelas' => $row['kelas'],
                'jurusan' => $row['jurusan'],
            ]);
        });
    }
}