<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPersyaratanSiswa extends Model
{
    protected $table = 'detail_persyaratan_siswa';

    protected $fillable = [
        'persyaratan_id',
        'peserta_id',
        'member_id',
        'isi_jawaban',
        'berkas_siswa',
        'status_verifikasi',
        'catatan',
    ];

    public function persyaratan()
    {
        return $this->belongsTo(
            Persyaratan::class,
            'persyaratan_id'
        );
    }
    public function member()
{
    return $this->belongsTo(
        MemberSiswa::class,
        'member_id'
    );
}

public function peserta()
{
    return $this->belongsTo(
        PesertaPendaftaran::class,
        'peserta_id'
    );
}
}
