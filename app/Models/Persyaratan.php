<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    protected $table = 'persyaratan';

    protected $fillable = [
        'ekstrakurikuler_id',
        'nama',
        'berkas',
        'tipe_persyaratan',
        'status',
        'foto',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }
}