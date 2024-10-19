<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teknisi extends Authenticatable
{
    use HasFactory;

    protected $table = "teknisi"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id', 'nama', 'jabatan', 'nipp', 'email', 'password', 'ttd', 'foto','status'
    ];

    protected $hidden = [
        'password',
    ];
}
