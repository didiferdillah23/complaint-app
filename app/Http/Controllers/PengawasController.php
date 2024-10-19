<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengawas;
use App\Models\Log_cetak_laporan;
use Barryvdh\DomPDF\Facade\Pdf;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Session; 

class PengawasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function regist (Request $request)
    {
        $pass = bcrypt($request->password);
        $ttd = $request->ttd;

        $existingUser = Pengawas::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->withInput()->withErrors(['error' => 'Gunakan Email yang Lain']);
        }

        $pengawas = Pengawas::create([
            'nama'      => $request->nama,
            'nipp'      => $request->nipp,
            'jabatan'   => $request->jabatan,
            'email'     => $request->email,
            'password'  => $pass,
            'status'    => 0
        ]);

        $id_pengawas = $pengawas->id;

        $nama_file_ttd = $id_pengawas . "_" . time() . "_" . $ttd->getClientOriginalName();
        $ttd->move(storage_path() . '/app/public/img/teknisi', $nama_file_ttd);

        DB::table('teknisi')
        ->where('id', $id_pengawas)
            ->update([
                'ttd'  => $nama_file_ttd
            ]);

        $msg = 'Berhasil';
        Session::flash('success', $msg);

        // dd($nama_file_ttd);
        return view('login');
    }

    public function profile ()
    {
        $dt = DB::table('pengawas')
        ->where('id','=', Auth::guard('pengawas')->user()->id)
        ->first();

        // dd($dt);

        return view('pengawas.profile',compact('dt'));
    }

    public function ttd(Request $request)
    {
        $ttd = $request->ttd;
        
        $getttd = DB::table('pengawas')
        ->select('ttd')
        ->where('id', Auth::guard('pengawas')->user()->id)
        ->first();

        $cekttd = $getttd->ttd;
        
        if($cekttd == ''){
            $nama_file_ttd = Auth::guard('pengawas')->user()->id . "_" . time() . "_" . $ttd->getClientOriginalName() ;
            $ttd->move(storage_path().'/app/public/img/pengawas', $nama_file_ttd);

            DB::table('pengawas')
            ->where('id', Auth::guard('pengawas')->user()->id)
            ->update([
                'ttd'  => $nama_file_ttd
            ]);
        } else if($cekttd != '' ){
            $nama_file_ttd = Auth::guard('pengawas')->user()->id . "_" . time() . "_" . $ttd->getClientOriginalName() ;
            $ttd->move(storage_path() . '/app/public/img/pengawas', $nama_file_ttd);

            DB::table('pengawas')
            ->where('id', Auth::guard('pengawas')->user()->id)
            ->update([
                'ttd'  => $nama_file_ttd
            ]);

            $old_ttd = $request->ttd_old;
            // unlink(storage_path('app/public/img/pengawas/'.$old_ttd));

        }
        
        // dd($ttd, $filettd);
        return redirect('profile-pengawas');
    }

    public function akun()
    {
        $pelapor = DB::table('pelapor as p')
        ->leftJoin('laporan as l', 'p.id', '=', 'l.id_pelapor')
        ->select(
            'p.id','p.nama','p.nipp','p.email','p.password',
            'p.jabatan','p.divisi','p.telepon','p.status',
            DB::raw('COUNT(l.id) AS jumlah_laporan')
        )
        ->where('status', '=', 1)
        ->groupBy('p.id', 'p.nama', 'p.nipp', 'p.email', 'p.password', 
        'p.jabatan', 'p.divisi', 'p.telepon', 'p.status',)
        // ->orderByDesc('p.created_at')
        ->get();

        $acc    = DB::table('pelapor')->where('status','=',0)->get();
        $cacc   = count($acc);

        $it = DB::table('teknisi as t')
        ->select(
            't.id',
            't.nama',
            't.nipp',
            't.email',
            't.jabatan',
            DB::raw('COUNT(l.id) AS jumlah_laporan')
        )
        ->leftJoin('laporan as l', 't.id', '=', 'l.id_teknisi')
        ->groupBy('t.id','t.nama','t.nipp','t.email','t.jabatan',
        )->get();

        // dd($acc);

        return view('pengawas.akun-user', compact('pelapor','it','cacc','acc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan()
    {
        $lap = DB::table('laporan')
        ->leftJoin(DB::raw('(SELECT id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
            $join->on('laporan.id', '=', 'latest_laporanhist.id_laporan');
        })
        ->leftJoin('laporanhist', function ($join) {
            $join->on('laporan.id', '=', 'laporanhist.id_laporan')
                ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
        })
        ->leftJoin('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
        ->leftJoin('pelapor','pelapor.id','=','laporan.id_pelapor')
        ->leftJoin('pengawas','pengawas.id','=','laporan.id_pengawas')
        ->select(
            DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
            DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y') AS tgl_selesai"),
            'laporan.no_inv_aset',
            'laporan.waktu_tambahan',
            'laporanhist.status_laporan as status_terakhir',
            'laporan.id AS id',
            'id_teknisi','lap_no_ref as no_ref','lap_bisnis_area as bisnis_area',
            'teknisi.nama as nama_teknisi',
            'laporan.lap_no_ref','laporan.lap_tanggal','laporan.lap_bisnis_area','laporan.lap_versi','laporan.lap_halaman','laporan.lap_nomor',
            'pelapor.nama AS nama_pelapor',
            'pelapor.divisi',
            'pelapor.email',
            'pelapor.telepon',
            'pelapor.nipp as nipp_pelapor',
            'pengawas.ttd'
        )
        ->where('laporanhist.status_laporan','=','Selesai')
        ->whereNull('id_pengawas')
        ->orderBy('tgl_masuk')
        ->get();
        
        // dd($lap);
        return view('pengawas.laporan', compact('lap'));
    }

    public function ambil($idlap)
    {
        DB::table('laporan')
        ->where('id', $idlap)
            ->update([
                'id_pengawas' => Auth::guard('pengawas')->user()->id
            ]);

        Session::flash('success'); 

        return back();
    }

    public function alih_laporan(Request $request, $idlap)
    {
        DB::table('laporan')
        ->where('id', $idlap)
            ->update([
                'alihkan_pws' => $request->id_pengawas
            ]);

        Session::flash('success');

        return back();
    }

    public function laporan_cetak()
    {
        $lap = DB::table('laporan')
        ->leftJoin(DB::raw('(SELECT id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
            $join->on('laporan.id', '=', 'latest_laporanhist.id_laporan');
        })
        ->leftJoin('laporanhist', function ($join) {
            $join->on('laporan.id', '=', 'laporanhist.id_laporan')
            ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
        })
        ->leftJoin('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
        ->leftJoin('pelapor', 'pelapor.id', '=', 'laporan.id_pelapor')
        ->leftJoin('pengawas', 'pengawas.id', '=', 'laporan.alihkan_pws')
        ->select(
            DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
            DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y') AS tgl_selesai"),
            'laporan.no_inv_aset',
            'laporan.waktu_tambahan',
            'laporanhist.status_laporan as status_terakhir',
            'laporan.id AS id',
            'id_teknisi',
            'lap_no_ref as no_ref',
            'lap_bisnis_area as bisnis_area',
            'teknisi.nama as nama_teknisi',
            'laporan.lap_no_ref',
            'laporan.lap_tanggal',
            'laporan.lap_bisnis_area',
            'laporan.lap_versi',
            'laporan.lap_halaman',
            'laporan.lap_nomor',
            'pelapor.nama AS nama_pelapor',
            'pelapor.divisi',
            'pelapor.email',
            'pelapor.telepon',
            'pelapor.nipp as nipp_pelapor',
            'pengawas.ttd','laporan.alihkan_pws','pengawas.nama as nama_pws'
        )
        ->where('laporanhist.status_laporan', '=', 'Selesai')
        ->where('id_pengawas','=', Auth::guard('pengawas')->user()->id)
        ->orderBy('tgl_masuk')
        ->get();

        $pengawas = DB::table('pengawas')->get();

        return view('pengawas.laporan-cetak',compact('lap','pengawas'));
    }

    public function cetak($idlap)
    {
        Carbon::setLocale('id');

        $detlap = DB::table('detlaporan')
        ->where('id_laporan', '=', $idlap)
            ->get();

        $lap = DB::table('laporan')
        ->leftJoin('pengawas', 'pengawas.id', '=', 'laporan.id_pengawas')
        ->leftJoin('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
        ->leftJoin('pelapor', 'pelapor.id', '=', 'laporan.id_pelapor')
        ->select(
            'pelapor.nama AS nama_pelapor',
            'pelapor.divisi',
            'pelapor.email',
            'pelapor.telepon',
            'pelapor.nipp as nipp_pelapor',
            'pelapor.ttd as ttd_pelapor',
            'pengawas.nama as nama_pengawas',
            'pengawas.nipp as nipp_pengawas',
            'pengawas.ttd as ttd_pengawas',
            'teknisi.nama as nama_teknisi',
            'teknisi.nipp as nipp_teknisi',
            'teknisi.ttd as ttd_teknisi',
            'laporan.id as idlap',
            'laporan.no_inv_aset',
            'laporan.lap_no_ref as no_ref',
            'laporan.lap_bisnis_area as bisnis_area',
            'laporan.lap_versi as versi',
            'laporan.lap_halaman as halaman',
            'laporan.lap_nomor as nomor',
            DB::raw("DATE_FORMAT(laporan.lap_tanggal, '%d-%m-%Y') AS tanggal"),
            DB::raw("DATE_FORMAT(laporan.tgl_masuk, '%d-%m-%Y') AS tgl_masuk"),
            DB::raw("DATE_FORMAT(laporan.tgl_masuk, '%H:%i WIB') AS waktu_masuk"),
            DB::raw("DATE_FORMAT(laporan.tgl_selesai, '%d-%m-%Y') AS tgl_selesai"),
            DB::raw("DATE_FORMAT(laporan.tgl_selesai, '%H:%i WIB') AS waktu_selesai"),
            DB::raw("DATE_FORMAT(laporan.tgl_awal_pengerjaan, '%d-%m-%Y') AS tgl_awal_pengerjaan"),
            DB::raw("DATE_FORMAT(laporan.tgl_awal_pengerjaan, '%H:%i WIB') AS waktu_awal_pengerjaan"),
            DB::raw("DATE_FORMAT(laporan.tgl_akhir_pengerjaan, '%d-%m-%Y') AS tgl_akhir_pengerjaan"),
            DB::raw("DATE_FORMAT(laporan.tgl_akhir_pengerjaan, '%H:%i WIB') AS waktu_akhir_pengerjaan")
        )
            ->where('laporan.id', '=', $idlap)
            ->first();
            
        if ($lap) {
            $tgl_awal_pengerjaan = Carbon::parse($lap->tgl_awal_pengerjaan)->translatedFormat('d F Y');
            $tgl_akhir_pengerjaan = Carbon::parse($lap->tgl_akhir_pengerjaan)->translatedFormat('d F Y');
        } else {
            $tgl_awal_pengerjaan = null;
            $tgl_akhir_pengerjaan = null;
        }

        $kop = DB::table('kop_surat')
        ->select([
            'nomor', DB::raw("DATE_FORMAT(tanggal, '%d %M %Y') AS tanggal_f"), 'versi', 'halaman', 'id'
        ])
        ->orderByDesc('created_at')
        ->first();

        if ($kop) {
            $tanggal_f = Carbon::parse($kop->tanggal_f)->translatedFormat('d F Y');
        } else {
            $tanggal = null;
        }

        $today = Carbon::now()->locale('id')->translatedFormat('d F Y'); 

        $no_ref = $lap->no_ref;
        $bisnis_area = $lap->bisnis_area;
        $tgl = date('dmY');
        $lap_no_ref = str_replace('/', '', $no_ref);

        $laporan = $lap_no_ref . "_" . $tgl . "_" . $bisnis_area . ".pdf";

        $pdf = Pdf::loadView('pengawas.cetakNew', compact('lap', 'detlap', 'tgl_awal_pengerjaan', 'tgl_akhir_pengerjaan', 'tanggal_f', 'kop'))
        ->setPaper('legal', 'portrait')
        ->set_option('isPhpEnabled', true)
        ->output();

        Log_cetak_laporan::create([
            'id_laporan'    => $idlap,
            'id_pengawas'   => Auth::guard('pengawas')->user()->id
        ]);
        
        return response()->streamDownload(
            fn () => print($pdf),
            $laporan
        );

        // return view('pengawas.cetakNew',compact('lap', 'detlap', 'tgl_awal_pengerjaan', 'tgl_akhir_pengerjaan', 'today'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $detlaporan = DB::table('detlaporan')
        ->where('id_laporan', '=', $id)->get();

        $laporan = DB::table('laporan')
        ->leftJoin(DB::raw('(SELECT id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
            $join->on('laporan.id', '=', 'latest_laporanhist.id_laporan');
        })
        ->leftJoin('laporanhist', function ($join) {
            $join->on('laporan.id', '=', 'laporanhist.id_laporan')
                ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
        })
        ->leftjoin('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
        ->where('laporan.id', '=', $id)
            ->select(
                DB::raw("DATE_FORMAT(laporan.tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                DB::raw("DATE_FORMAT(laporan.tgl_awal_pengerjaan, '%d %M %Y, %H:%i WIB') AS tgl_awal_pengerjaan"),
                DB::raw("DATE_FORMAT(laporan.tgl_akhir_pengerjaan, '%d %M %Y,  %H:%i WIB') AS tgl_akhir_pengerjaan"),
                'no_inv_aset',
                'waktu_tambahan',
                'id_teknisi',
                'teknisi.nama',
                'laporanhist.status_laporan as status_terakhir',
                'laporan.id as id',
                'lap_no_ref','lap_tanggal','lap_bisnis_area','lap_versi','lap_halaman','lap_nomor'
            )
            ->first();

        // dd($dtp);
        return view('pengawas.detail', compact('laporan','detlaporan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
