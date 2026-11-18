<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSeleksi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_seleksi';

    protected $fillable = [
        'pendaftaran_id',
        'tahap_seleksi', // ✅ Sudah sesuai
        'metode',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'keterangan',
    ];
    public function pendaftaran()
{
    return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
}
}