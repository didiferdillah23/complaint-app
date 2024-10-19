<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelapor extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = "pelapor"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id', 'nama', 'jabatan', 'nipp', 'email','telepon','divisi',
        'status','password', 'id_admin_tj','ttd','profile'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}


