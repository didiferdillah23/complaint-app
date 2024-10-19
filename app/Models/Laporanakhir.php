<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanakhir extends Model
{
    use HasFactory;
    protected $table = "laporanakhir"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id', 'id_laporan', 'no_ref', 'tanggal', 'bisnis_area',
        'versi','halaman','nomor'

    ]; 
}
