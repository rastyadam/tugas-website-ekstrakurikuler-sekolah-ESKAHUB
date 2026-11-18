<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSiswa extends Model
{
    use HasFactory;

    protected $table = 'member_siswa';

    protected $fillable = [
        'pengguna_id',
        'nisn',
        'nama',
        'jenis_kelamin',
        'email',
        'no_hp',
        'alamat',
        'kelas',
        'jurusan',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}