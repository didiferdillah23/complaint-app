<?php

namespace App\Http\Controllers;
use App\Models\Laporan;
use App\Models\Laporanakhir;
use App\Models\Laporanhist;
use App\Models\DetLaporan;
use App\Models\Teknisi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session; 

class TeknisiController extends Controller
{
    public function regist(Request $request)
    {
        $pass = bcrypt($request->password);
        $ttd = $request->ttd;

        $existingUser = Teknisi::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->withInput()->withErrors(['error' => 'Gunakan Email yang Lain']);
        }

        $teknisi = Teknisi::create([
            'nama'      => $request->nama,
            'nipp'      => $request->nipp,
            'email'     => $request->email,
            'password'  => $pass,
            'jabatan'   => $request->jabatan,
            'status'    => 0
        ]);

        $id_teknisi = $teknisi->id;

        $nama_file_ttd = $id_teknisi . "_" . time() . "_" . $ttd->getClientOriginalName();
        $ttd->move(storage_path() . '/app/public/img/teknisi', $nama_file_ttd);

        DB::table('teknisi')
        ->where('id', $id_teknisi)
            ->update([
                'ttd'  => $nama_file_ttd
            ]);

        $msg = 'Berhasil';
        Session::flash('success', $msg);

        // dd($nama_file_ttd);
        return view('login');
    }

    public function profile()
    {
        $dt = DB::table('teknisi')
        ->where('id', '=', Auth::guard('teknisi')->user()->id)
            ->first();

        // dd($dt);

        return view('teknisi.profile', compact('dt'));
    }

    public function ttd(Request $request)
    {
        $ttd = $request->ttd;

        $getttd = DB::table('teknisi')
        ->select('ttd')
        ->where('id', Auth::guard('teknisi')->user()->id)
            ->first();

        $cekttd = $getttd->ttd;

        if ($cekttd == '') {
            $nama_file_ttd = Auth::guard('teknisi')->user()->id . "_" . time() . "_" . $ttd->getClientOriginalName();
            $ttd->move(storage_path() . '/app/public/img/teknisi', $nama_file_ttd);

            DB::table('teknisi')
            ->where('id', Auth::guard('teknisi')->user()->id)
                ->update([
                    'ttd'  => $nama_file_ttd
                ]);
        } else if ($cekttd != '') {
            $nama_file_ttd = Auth::guard('teknisi')->user()->id . "_" . time() . "_" . $ttd->getClientOriginalName();
            $ttd->move(storage_path() . '/app/public/img/teknisi', $nama_file_ttd);

            DB::table('teknisi')
            ->where('id', Auth::guard('teknisi')->user()->id)
                ->update([
                    'ttd'  => $nama_file_ttd
                ]);

            $old_ttd = $request->ttd_old;
            unlink(storage_path('app/public/img/teknisi/' . $old_ttd));
        }

        // dd($ttd, $filettd);
        return redirect('profile-teknisi');
    }

    public function index()
    {
        $dtLap = DB::table('laporan as l')
        ->leftJoin(DB::raw('(SELECT id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
            $join->on('l.id', '=', 'latest_laporanhist.id_laporan');
        })
        ->leftJoin('laporanhist', function ($join) {
            $join->on('l.id', '=', 'laporanhist.id_laporan')
                ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
        })
        ->join('pelapor as p', 'p.id', '=', 'l.id_pelapor')
        ->select(
            DB::raw("DATE_FORMAT(l.tgl_masuk, '%d %M %Y') AS tgl_masuk"),
            DB::raw("DATE_FORMAT(l.tgl_akhir_pengerjaan, '%d %M %Y, %H:%i WIB') AS tgl_akhir_pengerjaan"),
            'l.no_inv_aset',
            'l.waktu_tambahan',
            'laporanhist.status_laporan AS status_terakhir',
            'l.id',
            'l.id_teknisi',
            'l.tgl_akhir_pengerjaan AS deadline',
            'p.nama as nama_pelapor'
        )
        ->where('laporanhist.status_laporan', 'Pengajuan')
        ->orderBy('l.tgl_masuk','asc')
        ->get();

        return view('teknisi.comp', compact('dtLap'));
    }

    public function index2()
    {
        $dtLap = DB::table('laporan')
        ->leftJoin(DB::raw('(SELECT id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
            $join->on('laporan.id', '=', 'latest_laporanhist.id_laporan');
        })
        ->leftJoin('laporanhist', function ($join) {
            $join->on('laporan.id', '=', 'laporanhist.id_laporan')
                ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
        })
        ->join('pelapor', 'pelapor.id', '=', 'laporan.id_pelapor')
        ->select(
            DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
            DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y,  %H:%i WIB') AS tgl_akhir_pengerjaan"),
            'no_inv_aset',
            'waktu_tambahan',
            'laporanhist.status_laporan as status_terakhir',
            'laporan.id',
            'id_teknisi',
            'laporan.tgl_akhir_pengerjaan AS deadline',
            'pelapor.nama as nama_pelapor'
        )
        ->whereNotIn('laporanhist.status_laporan', ['Selesai', 'Dibatalkan'])
        ->where('id_teknisi', '=', Auth::guard('teknisi')->user()->id)
        ->orderByDesc('laporan.created_at')
        ->get();

        // FORMAT TANGGAL '%d/%m/%Y %H:%i'

        // dd($dtLap);
        return view('teknisi.comp2', compact('dtLap'));
    }

    public function proses(Request $request, $id)
    {
        $action = $request->action;
        $tgl_masuk = Carbon::now()->format('Y-m-d H:i:s');

        if($action == 'process'){
            Laporanhist::create([
                'id_laporan'        => $id,
                'status_laporan'    => 'Diproses',
                'tanggal'           => $tgl_masuk,
            ]);

            DB::table('laporan')
            ->where('id', $id)
            ->update([
                'id_teknisi'        => Auth::guard('teknisi')->user()->id,
            ]);

        } 
        // else if ($action == 'reject') {
        //     Laporanhist::create([
        //         'id_laporan'        => $id,
        //         'status_laporan'    => 'Dibatalkan',
        //         'tanggal'           => $tgl_masuk,
        //         'keterangan'        => $request->keterangan
        //     ]);
        //     DB::table('laporan')
        //         ->where('id', $id)
        //         ->update([
        //             'status_terakhir' => 'Dibatalkan'
        //         ]);
        // }

        return redirect('layanan-it');
    }

    public function tambahwaktu(Request $request, $idlap)
    {
        $waktu_tambahan     = $request->waktu_tambahan;
        $keterangan         = $request->keterangan;
        $tgl_masuk          = Carbon::now()->format('Y-m-d H:i:s');

        Laporanhist::create([
            'id_laporan'        => $idlap,
            'status_laporan'    => 'reqAddTime',
            'tanggal'           => $tgl_masuk,
            'keterangan'        => $keterangan
        ]);

        DB::table('laporan')
        ->where('id', $idlap)
        ->update([
            'waktu_tambahan_peng' => $waktu_tambahan
        ]);

        // dd($waktu_tambahan, $keterangan);
        return redirect()->back();
    }

    public function resetwaktu(Request $request, $id)
    {
        DB::table('laporan')
        ->where('id', $id)
        ->update([
            'waktu_tambahan' => DB::raw('NULL')
        ]);

        Session::flash('success'); 

        // dd($waktu_tambahan, $keterangan);
        return redirect()->back();
    }

    public function detail($id)
    {
        $laporan = DB::table('laporan')
        ->leftJoin(DB::raw('(SELECT id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
            $join->on('laporan.id', '=', 'latest_laporanhist.id_laporan');
        })
        ->leftJoin('laporanhist', function ($join) {
            $join->on('laporan.id', '=', 'laporanhist.id_laporan')
                ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
        })
        ->leftjoin('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
        ->leftJoin('pelapor','pelapor.id','=','laporan.id_pelapor')
        ->where('laporan.id', '=', $id)
            ->select(
                'no_inv_aset',
                'waktu_tambahan','waktu_tambahan_peng',
                'id_teknisi','laporan.id AS id',
                'teknisi.nama','laporanhist.status_laporan AS status_terakhir',
                'laporan.tgl_akhir_pengerjaan AS deadline',
                DB::raw("DATE_FORMAT(laporan.tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                DB::raw("DATE_FORMAT(laporan.tgl_selesai, '%d %M %Y') AS tgl_selesai"),
                DB::raw("DATE_FORMAT(laporan.tgl_awal_pengerjaan, '%d %M %Y, %H:%i WIB') AS tgl_awal_pengerjaan"),
                DB::raw("DATE_FORMAT(laporan.tgl_akhir_pengerjaan, '%d %M %Y,  %H:%i WIB') AS tgl_akhir_pengerjaan"),
                'pelapor.nama as nama_pelapor', 'pelapor.jabatan as jabatan_pelapor','laporanhist.keterangan'
            )
            ->first();

        $detlaporan = DB::table('detlaporan')
        ->leftJoin('laporan','laporan.id','=','detlaporan.id_laporan')
        ->leftJoin(DB::raw('(SELECT laporanhist.id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
            $join->on('laporan.id', '=', 'latest_laporanhist.id_laporan');
        })
        ->leftJoin('laporanhist', function ($join) {
            $join->on('laporan.id', '=', 'laporanhist.id_laporan')
                ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
        })
        ->select(
            'detlaporan.id as id_det','laporan.id as id_lap','detlaporan.kat_layanan',
            'detlaporan.jenis_layanan',
            'detlaporan.det_layanan',
            'detlaporan.det_pekerjaan',
            'detlaporan.ket_pekerjaan',
            'laporanhist.status_laporan AS status_terakhir',
            'detlaporan.id_teknisi','detlaporan.acc_status'
        )
        ->where('detlaporan.id_laporan', '=', $id)
        // ->where(function ($query) {
        //     $query->whereNull('detlaporan.status')
        //         ->orWhere('detlaporan.acc_status', '!=', 'yes');
        // })
        ->get();

        $count = DetLaporan::where('id_laporan', $id)
        ->whereNull('det_pekerjaan')
        ->whereNull('ket_pekerjaan')
        ->count();

        // dd($detlaporan);

        return view('teknisi.comp-detail-it', compact('laporan', 'detlaporan','count'));
        
    }

    public function pekerjaanIT(Request $request, $id_det)
    {
        $det_pekerjaan  = $request->det_pekerjaan;
        $ket_pekerjaan  = $request->ket_pekerjaan;
        $status         = $request->status;
        $tgl_masuk  = Carbon::now()->format('Y-m-d H:i:s');

        $id_lap = DB::table('detlaporan')
        ->where('id',$id_det)
        ->first();

        if($status != null){
            DB::table('detlaporan')
            ->where('id', $id_det)
            ->update([
                'det_pekerjaan' => 'Permasalahan Tidak Sesuai',
                'ket_pekerjaan' => $ket_pekerjaan,
                'status'        => $status,
                'acc_status'    => 'waiting'
            ]);
            Laporanhist::create([
                'id_laporan'        => $id_lap->id_laporan,
                'status_laporan'    => 'CheckLapU', //cek pengajuan hapus laporan user
                'tanggal'           => $tgl_masuk,
                'keterangan'        => 'Pengecekan hapus pelaporan oleh User / Pelapor'
            ]);
        } else {
            DB::table('detlaporan')
                ->where('id', $id_det)
                ->update([
                    'det_pekerjaan' => $det_pekerjaan,
                    'ket_pekerjaan' => $ket_pekerjaan,
                    'acc_status'    => DB::raw('NULL'),
                    'status'        => DB::raw('NULL')
                ]);
        }

            // dd($request->all());

        return redirect()->back();
    }

    public function tambahpekerjaanIT(Request $request, $id)
    {
        $jenis_layanan  = $request->jenis_layanan;
        $kat_layanan    = $request->kat_layanan;
        $det_layanan    = $request->det_layanan;
        $det_pekerjaan  = $request->det_pekerjaan;
        $ket_pekerjaan  = $request->ket_pekerjaan;

        if($jenis_layanan == 'Lainnya') {
            $jenis_layanan = $request->layanan_lain;
        } else {
            $jenis_layanan = $request->jenis_layanan;
        }

        $existingEntry = DB::table('detlaporan')
        ->where('id_laporan',$id)
        ->where('kat_layanan', $request->kat_layanan)
        ->where('jenis_layanan', $jenis_layanan)
        // ->where('acc_status', '!=', 'yes')
        // ->orWhereNull('acc_status')
        ->where(function ($query) {
            $query->where('acc_status', '!=', 'yes')
                ->orWhereNull('acc_status');
        })
        ->orderBy('id', 'desc')
        ->exists();

        if ($existingEntry) {
            Session::flash('failed'); 
        } else {
            if ($request->jenis_layanan == "Lainnya") {
                $layanan_lain = $request->layanan_lain;
                DetLaporan::create([
                    'id_laporan'        => $id,
                    'kat_layanan'       => $request->kat_layanan,
                    'jenis_layanan'     => $layanan_lain,
                    'det_layanan'       => $request->det_layanan,
                    'det_pekerjaan'     => $det_pekerjaan,
                    'ket_pekerjaan'     => $request->ket_pekerjaan,
                    'id_teknisi'        => Auth::guard('teknisi')->user()->id
                ]);
            } else {
                DetLaporan::create([
                    'id_laporan'        => $id,
                    'kat_layanan'       => $request->kat_layanan,
                    'jenis_layanan'     => $request->jenis_layanan,
                    'det_layanan'       => $request->det_layanan,
                    'det_pekerjaan'     => $det_pekerjaan,
                    'ket_pekerjaan'     => $request->ket_pekerjaan,
                    'id_teknisi'        => Auth::guard('teknisi')->user()->id
                ]);
            }
        }

    
        dd($existingEntry, $jenis_layanan, $id);

        return redirect()->back();
    }

    public function hapuspekerjaanIT($id)
    {
        $hapus = DetLaporan::findorfail($id);
        $hapus->delete();

        Session::flash('hapus'); 

        // dd($result);

        return redirect()->back();
    }

    public function selesai(Request $request, $id) 
    {
        $tgl_masuk  = Carbon::now()->format('Y-m-d H:i:s');

        Laporanhist::create([
            'id_laporan'        => $id,
            'status_laporan'    => 'CheckedU',
            'tanggal'           => $tgl_masuk,
            'keterangan'        => 'Pengecekan hasil penyelesaian laporan oleh User / Pelapor'
        ]);

        DB::table('laporan')
        ->where('id', $id)
        ->update([
            'tgl_selesai'       => $tgl_masuk,
            'lap_bisnis_area'   => $request->lap_bisnis_area
        ]);

        $selesai = 'Menunggu Persetujuan Pelapor';
        Session::flash('success', $selesai); 

        // dd($request->all());
        return redirect('it');
    }

    public function history(Request $request)
    {
        $filter = $request->filter;
        $tgl_masuk = $request->tgl_masuk;
        $tgl_masuk_f = $request->tgl_masuk_f;
        $tgl_selesai = $request->tgl_selesai;
        $tgl_selesai_f = $request->tgl_selesai_f;
        $no_inv_aset = $request->no_inv_aset;
        $kat_layanan = $request->kat_layanan;

        if ($filter == null) {
            $data = DB::table('laporan')
            ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
            ->join('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
            ->select(
                'laporan.id AS id',
                'no_inv_aset',
                'tgl_selesai',
                'waktu_tambahan',
                'teknisi.nama as nama_teknisi',
                DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y') AS tgl_selesai"),
                DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                'laporan.lap_no_ref'
            )
                ->orderBy('laporanhist.tanggal', 'desc')
                ->where(function ($query) {
                    $query->where('laporanhist.status_laporan', '=', 'Selesai')
                    ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                })
                ->where('laporan.id_teknisi', '=', Auth::guard('teknisi')->user()->id)
                ->get();
        } else {
            if ($kat_layanan != null) {
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->join('detlaporan', 'detlaporan.id_laporan', '=', 'laporan.id')
                ->join('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
                ->orderBy('laporan.tgl_masuk', 'desc')
                    ->select(
                        'laporan.id AS id',
                        'no_inv_aset',
                        'tgl_selesai',
                        'kat_layanan',
                        'jenis_layanan',
                        'det_layanan',
                        'waktu_tambahan',
                        'detlaporan.foto',
                        'det_pekerjaan',
                        'ket_pekerjaan',
                        'kat_layanan',
                        'jenis_layanan',
                        'teknisi.nama as nama_teknisi',
                        DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                        DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                        DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                        'laporan.lap_no_ref'
                    )
                    ->where(function ($query) {
                        $query->where('laporanhist.status_laporan', '=', 'Selesai')
                        ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                    })
                    ->where('detlaporan.kat_layanan', '=', $kat_layanan)
                    ->where('laporan.id_teknisi', '=', Auth::guard('teknisi')->user()->id)
                    ->get();
                // dd($data);
            } else if ($no_inv_aset != null) {
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->join('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
                ->orderBy('laporan.tgl_masuk', 'desc')
                    ->select(
                        'laporan.id AS id',
                        'no_inv_aset',
                        'tgl_selesai',
                        'waktu_tambahan',
                        'teknisi.nama as nama_teknisi',
                        DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                        DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y') AS tgl_selesai"),
                        DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                        DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                        'laporan.lap_no_ref'
                    )
                    ->where(function ($query) {
                        $query->where('laporanhist.status_laporan', '=', 'Selesai')
                        ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                    })
                    ->where('laporan.no_inv_aset', '=', $no_inv_aset)
                    ->where('laporan.id_teknisi', '=', Auth::guard('teknisi')->user()->id)
                    ->get();
                // dd($data);
            } else if ($tgl_masuk != null) {
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->join('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
                ->orderBy('laporan.tgl_masuk', 'desc')
                    ->select(
                        'laporan.id AS id',
                        'no_inv_aset',
                        'tgl_selesai',
                        'waktu_tambahan',
                        'teknisi.nama as nama_teknisi',
                        DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                        DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y') AS tgl_selesai"),
                        DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                        DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                        'laporan.lap_no_ref'
                    )
                    ->where(function ($query) {
                        $query->where('laporanhist.status_laporan', '=', 'Selesai')
                        ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                    })
                    ->where('laporan.tgl_masuk', $tgl_masuk_f, $tgl_masuk)
                    ->where('laporan.id_teknisi', '=', Auth::guard('teknisi')->user()->id)
                    ->get();
                // dd($data);
            } else if ($tgl_selesai != null) {
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->join('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
                ->orderBy('laporan.tgl_masuk', 'desc')
                    ->select(
                        'laporan.id AS id',
                        'no_inv_aset',
                        'tgl_selesai',
                        'waktu_tambahan',
                        'teknisi.nama as nama_teknisi',
                        DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                        DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y') AS tgl_selesai"),
                        DB::raw("DATE_FORMAT(tgl_awal_pengerjaan, '%d %M %Y (%H:%i)') AS tgl_awal_pengerjaan"),
                        DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y  (%H:%i)') AS tgl_akhir_pengerjaan"),
                        'laporan.lap_no_ref'
                    )
                    ->where(function ($query) {
                        $query->where('laporanhist.status_laporan', '=', 'Selesai')
                        ->orWhere('laporanhist.status_laporan', '=', 'Dibatalkan');
                    })
                    ->where('laporan.id_teknisi', '=', Auth::guard('teknisi')->user()->id)
                    ->get();
                // dd($data);
            }
        }

        foreach ($data as $laporan) {
            $laporan->history = DB::table('laporanhist')
            ->where('id_laporan', $laporan->id)
                ->orderBy('created_at', 'desc')
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
        return view('teknisi.history-it', compact('data', 'datas', 'filter', 'kat_layanan'));
    }

    public function getNoInventarisOptionsIT()
    {
        $options = '';

        $noInventaris = DB::table('laporan')
        ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
        ->where('laporanhist.status_laporan', ['Selesai', 'Dibatalkan'])
        ->where('laporan.id_pelapor', '=', Auth::guard('teknisi')->user()->id)
            ->get();

        foreach ($noInventaris as $noInv) {
            $options .= '<option name=""no_inv_aset" value="' . $noInv->no_inv_aset . '">' . $noInv->no_inv_aset . '</option>';
        }

        return response()->json(['options' => $options]);
    }
}
