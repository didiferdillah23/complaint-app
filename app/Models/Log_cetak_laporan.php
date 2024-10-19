<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_cetak_laporan extends Model
{
    use HasFactory;
    protected $table = "log_cetak_laporan"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id', 'id_laporan', 'id_pengawas'
    ]; 
}
