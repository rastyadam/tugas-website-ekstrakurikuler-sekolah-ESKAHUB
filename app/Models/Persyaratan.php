<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    protected $table = 'persyaratan';
    protected $fillable = ['nama', 'berkas', 'tipe_persyaratan', 'status', 'foto'];
}