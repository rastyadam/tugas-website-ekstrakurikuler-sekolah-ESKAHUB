<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailPersyaratanSiswa extends Model
{
    protected $table = 'detail_persyaratan_siswa';
    protected $fillable = ['persyaratan_id', 'peserta_id', 'member_id'];
    
    // Kalau kamu mau nambahin kolom berkas di DB, tambahkan di sini
    // protected $fillable = ['persyaratan_id', 'peserta_id', 'member_id', 'berkas'];
}