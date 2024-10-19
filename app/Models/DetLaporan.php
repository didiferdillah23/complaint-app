<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetLaporan extends Model
{
    use HasFactory;
    protected $table = "detlaporan"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id', 'id_laporan','id_teknisi','kat_layanan', 'jenis_layanan', 'det_layanan', 'status','acc_status',
        'foto', 'det_pekerjaan', 'ket_pekerjaan'
    ]; 
}
