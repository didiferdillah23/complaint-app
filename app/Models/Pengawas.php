<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengawas extends Authenticatable
{
    use HasFactory;
    protected $table = "pengawas"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id', 'nama', 'nipp', 'email', 'password','ttd','status','jabatan'
    ];

    protected $hidden = [
        'password',
    ];
}
