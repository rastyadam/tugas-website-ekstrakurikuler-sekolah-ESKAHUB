<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPendaftaran extends Model
{
    use HasFactory;

    // ✅ Kasih tahu Laravel nama tabelnya
    protected $table = 'peserta_pendaftaran';

    protected $fillable = [
        'gelombang_id',
        'nisn',
        'nama',
        'tanggal_lahir',
        'tanggal_daftar',
        'alokasi',
    ];
}