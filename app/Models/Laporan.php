<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = "laporan"; //cek
    protected $primaryKey = "id"; //cek

    protected $fillable = [
        'id','id_pelapor','id_pengawas','id_admin', 'alihkan_pws','tgl_masuk','no_inv_aset','tgl_selesai','status_terakhir',
        'tgl_awal_pengerjaan','tgl_akhir_pengerjaan','waktu_tambahan', 'waktu_tambahan_peng',
    ]; 
}
