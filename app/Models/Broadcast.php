<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory;
    protected $table = "broadcast"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id', 'judul','informasi','tgl_tampil','tgl_selesai','status'
    ]; 
}
