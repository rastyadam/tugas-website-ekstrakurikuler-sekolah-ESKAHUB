<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_latihan';

    protected $fillable = [
        'ekstrakurikuler_id',
        'jenis_latihan',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'keterangan'
    ];

    // ✅ TAMBAHKAN INI
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }
}