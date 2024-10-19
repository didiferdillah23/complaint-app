<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kop_surat extends Model
{
    use HasFactory;
    protected $table        = "kop_surat"; //cek
    protected $primaryKey   = "id"; //cek

    protected $fillable = [
        'id', 'atas_1','atas_2','bawah','gambar','keterangan','nomor','versi','tanggal','halaman','preview'
    ];
}
