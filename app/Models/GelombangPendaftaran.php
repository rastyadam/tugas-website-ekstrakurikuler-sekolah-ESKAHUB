<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GelombangPendaftaran extends Model
{
    use HasFactory;

    // ✅ INI YANG PALING PENTING
    protected $table = 'gelombang_pendaftaran'; 

    protected $fillable = [
        'nama',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
}