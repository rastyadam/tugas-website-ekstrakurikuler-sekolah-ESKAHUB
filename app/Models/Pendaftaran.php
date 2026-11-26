<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'nisn',
        'member_id',
        'peserta_id',
        'ekstrakurikuler_id',
        'status',
        'nomor_pendaftaran',
        'tanggal_daftar',
    ];

    // Relasi ke MemberSiswa (Siswa yang mendaftar)
    public function member()
    {
        return $this->belongsTo(MemberSiswa::class, 'member_id');
    }

    // Relasi ke PesertaPendaftaran
    public function peserta()
    {
        return $this->belongsTo(PesertaPendaftaran::class, 'peserta_id');
    }

    // Relasi ke Ekstrakurikuler
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }
    public function detailPersyaratan()
{
    return $this->hasMany(
        DetailPersyaratanSiswa::class,
        'peserta_id',
        'peserta_id'
    );
}
public function jadwalSeleksi()
{
    return $this->hasMany(JadwalSeleksi::class, 'pendaftaran_id');
}
}