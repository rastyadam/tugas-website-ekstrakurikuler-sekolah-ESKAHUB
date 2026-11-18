<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'nama',
        'foto',
        'deskripsi',
        'kuota',
        'status',
        'pembina_id',
    ];

    // Relasi ke Pembina
    public function pembina()
    {
        return $this->belongsTo(Pembina::class, 'pembina_id');
    }
    public function pendaftarans()
{
    return $this->hasMany(Pendaftaran::class, 'ekstrakurikuler_id');
}
public function jadwalLatihan()
{
    return $this->hasMany(JadwalLatihan::class, 'ekstrakurikuler_id');
}
}