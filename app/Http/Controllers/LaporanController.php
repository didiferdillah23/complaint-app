<?php

namespace App\Http\Controllers;

use App\Models\DetLaporan;
use App\Models\Laporan;
use App\Models\Laporanakhir;
use App\Models\Laporanhist;
use App\Models\Broadcast;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; 

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashU() 
    {
        $dtLap = DB::table('laporan')
        ->leftJoin(DB::raw('(SELECT id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
            $join->on('laporan.id', '=', 'latest_laporanhist.id_laporan');
        })
        ->leftJoin('laporanhist', function ($join) {
            $join->on('laporan.id', '=', 'laporanhist.id_laporan')
                ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
        })
        ->select('laporanhist.status_laporan as status_terakhir')
        ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
        ->get();

        $open       = $dtLap->where('status_terakhir', 'Pengajuan')->count();
        $proses     = $dtLap->whereIn('status_terakhir', ['Diproses', 'reqAddTime','CheckedU'])->count();
        $selesai    = $dtLap->where('status_terakhir', 'Selesai')->count();
        $ditunda    = $dtLap->whereIn('status_terakhir', ['CheckedU', 'reqAddTime', 'CheckLapU'])->count();
        $all        = $dtLap->count();

        $bc = DB::table('broadcast')
        ->select([
            'judul', 'informasi', 'status', 'id',
            DB::raw("DATE_FORMAT(tgl_tampil, '%d %M %Y, %H:%i WIB') AS tgl_tampil"),
            DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y, %H:%i WIB') AS tgl_selesai"),
        ])
        ->whereDate('tgl_tampil', '<=', now())
        ->whereDate('tgl_selesai', '>=', now())
        ->get();
        
        // dd($statusSelesaiCount);
        return view('pelapor.dashboard', compact('selesai','open','proses','ditunda','bc'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tgl_masuk = Carbon::now()->format('Y-m-d H:i:s');

        // KONVERSI TANGGAL AWAL DAN AKHIR PENGERJAAN
        $tgl_awal = $request->tgl_awal;
        $waktu_awal = $request->waktu_awal;
        $tgl_akhir = $request->tgl_akhir;
        $waktu_akhir = $request->waktu_akhir;

        $tgl_awal_pengerjaan = Carbon::createFromFormat('d/m/Y H:i', $tgl_awal . ' ' . $waktu_awal)->format('Y-m-d H:i:s');
        $tgl_akhir_pengerjaan = Carbon::createFromFormat('d/m/Y H:i', $tgl_akhir . ' ' . $waktu_akhir)->format('Y-m-d H:i:s');
        // END KONVERSI TANGGAL AWAL DAN AKHIR PENGERJAAN


        $katLayanan = $request->kat_layanan;
        $jenisLayanan = $request->jenis_layanan;

        // Pengecekan antara kat_layanan dan jenis_layanan dengan nomor array yang sama
        // $data = '';
        for ($i = 1; $i < count($katLayanan); $i++) {
            for ($j = 0; $j < $i; $j++) {
                if ($katLayanan[$i] === $katLayanan[$j] && $jenisLayanan[$i] === $jenisLayanan[$j]) {
                    // Jika data sama dengan data sebelumnya, kembalikan response error
                    return back()->withInput()->withErrors(['error' => 'Kategori dan Jenis Laporan tidak boleh ada yang serupa saat memasukkan laporan lebih dari satu']);
                }
            }
        }
        $laporan = Laporan::create([
            'id_pelapor'            => Auth::guard('pelapor')->user()->id,
            'no_inv_aset'           => $request->no_inv_aset,
            'tgl_masuk'             => $tgl_masuk,
            'tgl_awal_pengerjaan'   => $tgl_awal_pengerjaan,
            'tgl_akhir_pengerjaan'  => $tgl_akhir_pengerjaan,
        ]);
        $id_laporan = $laporan->id; 

        if (count($request->kat_layanan) > 0) {
            foreach ($request->kat_layanan as $key => $value) {
                
                $jenis_layanan = $request->jenis_layanan[$key];

                if ($jenis_layanan == "Lainnya") {
                    $layanan_lain = $request->layanan_lain[$key];
                    $data = array(
                        'id_pelapor'    => Auth::guard('pelapor')->user()->id,
                        'id_laporan'    => $id_laporan,
                        'kat_layanan'   => $request->kat_layanan[$key],
                        'jenis_layanan' => $layanan_lain,
                        'det_layanan'   => $request->det_layanan[$key],
                    );
                } else {
                    $data = array(
                        'id_pelapor'    => Auth::guard('pelapor')->user()->id,
                        'id_laporan'    => $id_laporan,
                        'kat_layanan'   => $request->kat_layanan[$key],
                        'jenis_layanan' => $request->jenis_layanan[$key],
                        'det_layanan'   => $request->det_layanan[$key],
                    );
                }
                DetLaporan::create($data);
            }
        }

        Laporanhist::create([
            'id_laporan'    => $id_laporan,
            'status_laporan' => 'Pengajuan',
            'tanggal'       => $tgl_masuk
        ]);


        // dd($tgl_awal, $tgl_akhir, $tgl_awal_pengerjaan, $tgl_akhir_pengerjaan, $tgl_masuk);
        return redirect('comp');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function update(Request $request, $idlap)
    {
        $action     = $request->input('action');
        $tgl_masuk  = Carbon::now()->format('Y-m-d H:i:s');

        if ($action === 'accept') {
            Laporanhist::create([
                'id_laporan'        => $idlap,
                'status_laporan'    => 'Diproses',
                'tanggal'           => $tgl_masuk,
                'keterangan'        => 'Penambahan waktu diterima'
            ]);
        } elseif ($action === 'reject') {
            Laporanhist::create([
                'id_laporan'        => $idlap,
                'status_laporan'    => 'Dibatalkan',
                'tanggal'           => $tgl_masuk,
                'keterangan'        => 'Permintaan penambahan waktu tidak diterima'
            ]);
            DB::table('laporan')
            ->where('id', $idlap)
            ->update([
                'waktu_tambahan'  => DB::raw('NULL'),
                'tgl_selesai' => $tgl_masuk
            ]);
        } elseif ($action === 'finished') {
            Laporanhist::create([
                'id_laporan'        => $idlap,
                'status_laporan'    => 'Selesai',
                'tanggal'           => $tgl_masuk,
            ]);

            DB::table('laporan')
                ->where('id', $idlap)
                ->update([
                    'tgl_selesai'  => $tgl_masuk,
                ]);

            Laporanakhir::create([
                'id_laporan'        => $idlap,
                'tgl_akhir'         => $tgl_masuk,
            ]);
            
        }


        return redirect('comp');
        // dd($action);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, $idlap)
    {
        $tgl_masuk = Carbon::now()->format('Y-m-d H:i:s');

        Laporanhist::create([
            'id_laporan'        => $idlap,
            'status_laporan'    => 'Selesai',
            'tanggal'           => $tgl_masuk,
        ]);

        DB::table('laporan')
        ->where('id', $idlap)
        ->update([
            'tgl_selesai'  => $tgl_masuk,
        ]);

        return redirect('comp');
        // dd($tgl_masuk, $idlap);

    }

    public function historyU(Request $request)
    {
        $filter = $request->filter;
        $tgl_masuk = $request->tgl_masuk;
        $tgl_masuk_f = $request->tgl_masuk_f;
        $tgl_selesai = $request->tgl_selesai;
        $tgl_selesai_f = $request->tgl_selesai_f;
        $no_inv_aset = $request->no_inv_aset;
        $kat_layanan = $request->kat_layanan;

        if($filter == null){
            $data = DB::table('laporan')
            ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
            ->select(
                'laporan.id AS id',
                'no_inv_aset',
                'tgl_selesai',
                'waktu_tambahan',
                DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y') AS tgl_selesai"),
                DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
            )
            ->orderBy('laporanhist.tanggal', 'desc')
                ->where(function ($query) {
                    $query->where('laporanhist.status_laporan', '=', 'Selesai')
                        ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                })
            ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id )
            ->get();
            
        } else {
            if($kat_layanan != null){
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->orderBy('laporan.tgl_masuk', 'desc')
                ->select('laporan.id AS id','no_inv_aset', 'tgl_selesai','kat_layanan','jenis_layanan',
                    'det_layanan','waktu_tambahan', 'laporan.foto','det_pekerjaan','ket_pekerjaan',
                    DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                    DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                    DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                )
                ->where(function ($query) {
                    $query->where('laporanhist.status_laporan', '=', 'Selesai')
                        ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                })
                ->where('laporan.kat_layanan','=',$kat_layanan)
                ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
                ->get();
                // dd($data);
            } else if($no_inv_aset != null){
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->orderBy('laporan.tgl_masuk', 'desc')
                ->select('laporan.id AS id','no_inv_aset', 'tgl_selesai','kat_layanan','jenis_layanan',
                    'det_layanan','waktu_tambahan', 'laporan.foto','det_pekerjaan','ket_pekerjaan',
                    DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                    DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                    DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                )
                    ->where(function ($query) {
                        $query->where('laporanhist.status_laporan', '=', 'Selesai')
                            ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                    })
                ->where('laporan.no_inv_aset','=',$no_inv_aset)
                ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
                ->get();
                // dd($data);
            } else if ($tgl_masuk != null){
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->orderBy('laporan.tgl_masuk', 'desc')
                ->select('laporan.id AS id','no_inv_aset', 'tgl_selesai','kat_layanan','jenis_layanan',
                    'det_layanan','waktu_tambahan', 'laporan.foto','det_pekerjaan','ket_pekerjaan',
                    DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                    DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                    DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                )
                    ->where(function ($query) {
                        $query->where('laporanhist.status_laporan', '=', 'Selesai')
                            ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                    })
                ->where('laporan.tgl_masuk',$tgl_masuk_f,$tgl_masuk)
                ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
                ->get();
                // dd($data);
            }  else if ($tgl_selesai != null){
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->orderBy('laporan.tgl_masuk', 'desc')
                ->select('laporan.id AS id','no_inv_aset', 'tgl_selesai','kat_layanan','jenis_layanan',
                    'det_layanan','waktu_tambahan', 'laporan.foto','det_pekerjaan','ket_pekerjaan',
                    DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                    DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                    DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                )
                    ->where(function ($query) {
                        $query->where('laporanhist.status_laporan', '=', 'Selesai')
                            ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                    })
                ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
                ->get();
                // dd($data);
            }
        }

        foreach ($data as $laporan) {
            $laporan->history = DB::table('laporanhist')
            ->where('id_laporan', $laporan->id)
                ->orderBy('tanggal', 'desc')
                ->select(
                    'id',
                    'id_laporan',
                    'status_laporan',
                    'keterangan',
                    'foto',
                    DB::raw("DATE_FORMAT(tanggal, '%d %M %Y (%H:%i:%s)') AS tanggal"),
                )
                ->get();
        }

        if ($data->count() == 0) {
            $datas = 'tidak ada';
        } else {
            $datas = 'ada';
        }
        return view('pelapor.history-u', compact('data', 'datas','filter'));
    }

    public function getNoInventarisOptions()
    {
        $options = '';

        $noInventaris = DB::table('laporan')
        ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
        ->where('laporanhist.status_laporan', ['Selesai', 'Dibatalkan'])
        ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
        ->get();

        foreach ($noInventaris as $noInv) {
            $options .= '<option name=""no_inv_aset" value="' . $noInv->no_inv_aset . '">' . $noInv->no_inv_aset . '</option>';
        }

        return response()->json(['options' => $options]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $idlap)
    {
        $tgl_masuk = Carbon::now()->format('Y-m-d H:i:s');

        Laporanhist::create([
            'id_laporan'        => $idlap,
            'status_laporan'    => 'Dibatalkan',
            'tanggal'           => $tgl_masuk,
            'keterangan'        => $request->keterangan
        ]);

        $batal = 'Laporan Berhasil Dibatalkan';
        Session::flash('batal', $batal);

        return redirect('comp');
    }
}
