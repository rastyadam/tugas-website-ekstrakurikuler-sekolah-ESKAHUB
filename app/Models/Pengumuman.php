<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumuman';

    protected $fillable = [
        'peserta_id',
        'ekstrakurikuler_id',
        'judul',
        'isi',
        'alasan_penolakan',
        'status',
        'tanggal_daftar',
    ];

    // Relasi ke Peserta Pendaftaran
    public function peserta()
    {
        return $this->belongsTo(PesertaPendaftaran::class, 'peserta_id');
    }

    // Relasi ke Ekstrakurikuler (untuk info umum)
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }
}