<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'username',
        'kata_sandi',
        'peran',
         'harus_ganti_password',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'kata_sandi' => 'hashed',
        ];
    }

    // ⚠️ Kunci: kasih tahu Laravel kolom password-nya 'kata_sandi'
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    // Relasi ke profil siswa
    public function memberSiswa()
    {
        return $this->hasOne(MemberSiswa::class, 'pengguna_id');
    }
    public function pembina()
{
    return $this->hasOne(Pembina::class, 'user_id');
}
}