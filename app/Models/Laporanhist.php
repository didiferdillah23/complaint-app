<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanhist extends Model
{
    use HasFactory;
    protected $table = "laporanhist"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id', 'id_laporan', 'status_laporan', 'tanggal', 'keterangan','foto'
    ]; 
}
