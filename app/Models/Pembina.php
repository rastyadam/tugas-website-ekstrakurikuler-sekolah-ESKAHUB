<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembina extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel di database
    protected $table = 'pembina';

    protected $fillable = [
        'user_id',
        'nama',
        'jenis_pembina',
        'no_hp',
        'asal',
    ];

    // Relasi ke tabel Pengguna (Akun Login)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    // Relasi ke tabel Ekstrakurikuler (1 Pembina bisa membina banyak ekskul)
    public function ekstrakurikuler()
    {
        return $this->hasMany(Ekstrakurikuler::class, 'pembina_id');
    }
    public function pembina()
{
    return $this->hasOne(Pembina::class, 'user_id');
}
}