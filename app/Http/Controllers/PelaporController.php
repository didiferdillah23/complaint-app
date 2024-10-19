<?php

namespace App\Http\Controllers;

use App\Models\Pelapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DetLaporan;
use App\Models\Laporan;
use App\Models\Laporanakhir;
use App\Models\Laporanhist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; 

class PelaporController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $dtLap = DB::table('laporan')
        // ->select(
        //     'no_inv_aset',
        //     'waktu_tambahan',
        //     'status_terakhir',
        //     'id',
        //     'laporan.tgl_akhir_pengerjaan AS deadline',
        //     DB::raw("DATE_FORMAT(tgl_masuk, '%d %M %Y') AS tgl_masuk"),
        //     DB::raw("DATE_FORMAT(tgl_akhir_pengerjaan, '%d %M %Y,  %H:%i WIB') AS tgl_akhir_pengerjaan"),
        // )
        //     ->whereNotIn('status_terakhir', ['Selesai', 'Dibatalkan', 'Manager'])
        //     ->where('id_pelapor', '=', Auth::guard('pelapor')->user()->id)
        //     ->orderBy('tgl_masuk')
        //     ->get();

        $dtLap = DB::table('laporan')
            ->leftJoin(DB::raw('(SELECT id_laporan, MAX(tanggal) AS tanggal FROM laporanhist GROUP BY id_laporan) AS latest_laporanhist'), function ($join) {
                $join->on('laporan.id', '=', 'latest_laporanhist.id_laporan');
            })
            ->leftJoin('laporanhist', function ($join) {
                $join->on('laporan.id', '=', 'laporanhist.id_laporan')
                ->on('laporanhist.tanggal', '=', 'latest_laporanhist.tanggal');
            })
            ->leftJoin('pelapor', 'laporan.id_pelapor', '=', 'pelapor.id')
            ->select(
                'pelapor.nama',
                'pelapor.divisi',
                'pelapor.telepon',
                'pelapor.email',
                'laporan.id AS idlap',
                'laporan.waktu_tambahan',
                DB::raw("DATE_FORMAT(laporan.tgl_masuk, '%d %M %Y') AS tgl_masuk"),
                'laporan.no_inv_aset',
                DB::raw("DATE_FORMAT(laporan.tgl_akhir_pengerjaan, '%d %M %Y,  %H:%i WIB') AS tgl_akhir_pengerjaan"),
                'laporan.tgl_akhir_pengerjaan AS deadline',
                'laporanhist.tanggal AS tanggal_status_terbaru',
                'laporanhist.keterangan',
                'laporanhist.status_laporan AS status_terakhir',
                'laporanhist.id AS idhist',
                'laporan.id as id'
            )
            ->whereNotIn('laporanhist.status_laporan', ['Selesai', 'Dibatalkan'])
            ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
            ->orderBy('laporanhist.tanggal', 'desc')
            ->get();

        // FORMAT TANGGAL '%d/%m/%Y %H:%i'

        return view('pelapor.complaint', compact('dtLap')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        ->leftjoin('teknisi','teknisi.id','=','laporan.id_teknisi')
        ->where('laporan.id','=',$id)
        ->select(
            DB::raw("DATE_FORMAT(laporan.tgl_masuk, '%d %M %Y') AS tgl_masuk"),
            DB::raw("DATE_FORMAT(laporan.tgl_selesai, '%d %M %Y') AS tgl_selesai"),
            DB::raw("DATE_FORMAT(laporan.tgl_awal_pengerjaan, '%d %M %Y, %H:%i WIB') AS tgl_awal_pengerjaan"),
            DB::raw("DATE_FORMAT(laporan.tgl_akhir_pengerjaan, '%d %M %Y,  %H:%i WIB') AS tgl_akhir_pengerjaan"),
            'no_inv_aset','waktu_tambahan','id_teknisi','teknisi.nama',
            'waktu_tambahan_peng',
            'laporanhist.status_laporan as status_terakhir','laporan.id as idlap',
            'laporan.tgl_akhir_pengerjaan AS deadline','laporan.id AS idlap',
            'laporanhist.keterangan as keterangan'
        )
        ->first();

        $detlaporan = DB::table('detlaporan')
        ->where('id_laporan','=',$id)
        // ->whereNull('id_teknisi')
        // ->orWhere('acc_status','!=','yes')
        ->get();

        $hislap = DB::table('laporanhist')
        ->join('laporan','laporan.id','=','laporanhist.id_laporan')
        ->orderBy('tanggal', 'desc')
        ->first();

        // dd($detlaporan);
        return view('pelapor.comp-detail', compact('laporan','detlaporan','hislap'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function regist(Request $request)
    {
        $pass = bcrypt($request->password);
        $ttd = $request->ttd;

        $existingUser = Pelapor::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->withInput()->withErrors(['error' => 'Gunakan Email yang Lain']);
        }

        $pelapor = Pelapor::create([
            'nama'      => $request->nama,
            'nipp'      => $request->nipp,
            'email'     => $request->email,
            'password'  => $pass,
            'jabatan'   => $request->jabatan,
            'divisi'    => $request->divisi,
            'telepon'   => $request->telepon,
            'status'    => 0
        ]);

        $id_pelapor = $pelapor->id; 

        $nama_file_ttd = $id_pelapor . "_" . time() . "_" . $ttd->getClientOriginalName();
        $ttd->move(storage_path() . '/app/public/img/pelapor', $nama_file_ttd);

        DB::table('pelapor')
            ->where('id', $id_pelapor)
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
        $dt = DB::table('pelapor')
        ->where('id', '=', Auth::guard('pelapor')->user()->id)
        ->first();

        // dd($dt);

        return view('pelapor.profile', compact('dt'));
    }

    public function ttd(Request $request)
    {
        $ttd = $request->ttd;

        $getttd = DB::table('pelapor')
        ->select('ttd')
        ->where('id', Auth::guard('pelapor')->user()->id)
            ->first();

        $cekttd = $getttd->ttd;

        if ($cekttd == '') {
            $nama_file_ttd = Auth::guard('pelapor')->user()->id . "_" . time() . "_" . $ttd->getClientOriginalName();
            $ttd->move(storage_path() . '/app/public/img/pelapor', $nama_file_ttd);

            DB::table('pelapor')
            ->where('id', Auth::guard('pelapor')->user()->id)
                ->update([
                    'ttd'  => $nama_file_ttd
                ]);
        } else if ($cekttd != '') {
            $nama_file_ttd = Auth::guard('pelapor')->user()->id . "_" . time() . "_" . $ttd->getClientOriginalName();
            $ttd->move(storage_path() . '/app/public/img/pelapor', $nama_file_ttd);

            DB::table('pelapor')
            ->where('id', Auth::guard('pelapor')->user()->id)
                ->update([
                    'ttd'  => $nama_file_ttd
                ]);

            $old_ttd = $request->ttd_old;
            // unlink(storage_path('app/public/img/pelapor/' . $old_ttd));
        }

        // dd($ttd, $filettd);
        return redirect('profile-pelapor');
    }

    public function foto(Request $request)
    {
        $profile = $request->profile;

        $getprofile = DB::table('pelapor')
        ->select('profile')
            ->where('id', Auth::guard('pelapor')->user()->id)
            ->first();

        $cekprofile = $getprofile->profile;

        if ($cekprofile == '') {
            $nama_file_profile = Auth::guard('pelapor')->user()->id . "_" . time() . "_" . $profile->getClientOriginalName();
            $profile->move(storage_path() . '/app/public/img/pp_pelapor/', $nama_file_profile);

            DB::table('pelapor')
            ->where('id', Auth::guard('pelapor')->user()->id)
                ->update([
                    'profile'  => $nama_file_profile
                ]);
        } else if ($cekprofile != '') {
            $nama_file_profile = Auth::guard('pelapor')->user()->id . "_" . time() . "_" . $profile->getClientOriginalName();
            $profile->move(storage_path() . '/app/public/img/pp_pelapor/', $nama_file_profile);

            DB::table('pelapor')
            ->where('id', Auth::guard('pelapor')->user()->id)
                ->update([
                    'profile'  => $nama_file_profile
                ]);

            $old_profile = $request->profile_old;
            // dd($old_profile);
            // unlink(storage_path('app/public/img/pp_pelapor/' . $old_profile));
        }


        // dd($profile, $fileprofile);
        return redirect('profile-pelapor');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acclap(Request $request, $idlap)
    {
        $action = $request->action;
        $tgl_masuk = Carbon::now()->format('Y-m-d H:i:s');

        // == PEMBUATAN NOMOR REFERENSI ==
        // Dapatkan nomor referensi terakhir dari database
        $lastReferenceNumber = DB::table('laporan')
        ->whereNotNull('lap_no_ref')
        ->orderBy('id', 'desc')
        ->value('lap_no_ref');
        $tanggal = Carbon::now()->format('m/Y');
        $bulan = Carbon::now()->format('m');
        // Code Auto Increament
        $autoIncrement = 1;
        if ($lastReferenceNumber) {
            $lastReferenceNumberParts = explode('/', $lastReferenceNumber);
            // Periksa jika masih dibulan yang sama
            if ($lastReferenceNumberParts[1] === $bulan) {
                $autoIncrement = intval($lastReferenceNumberParts[0]) + 1;
            }
        }
        $lap_no_ref = sprintf('%03d', $autoIncrement) . '/' . $tanggal;
        // == END PEMBUATAN NOMOR REFERENSI ==

        // // == PEMBUATAN NOMOR LAPORAN ==
        // $bulan = date('m'); // Format bulan dua digit
        // $tahun = date('Y'); // Format tahun empat digit
        // $lap_nomor = "FR.SM/IT/011.005/{$bulan}-{$tahun}";
        // // == END PENBUATAN NOMOR LAPORAN ==

        // // == PEMBUATAN VERSI ==
        // $lap_versi = "002-{$tahun}";
        // // == END PENBUATAN VERSI ==

        if($action == 'accept') {
            Laporanhist::create([
                'id_laporan'        => $idlap,
                'status_laporan'    => 'Selesai',
                'tanggal'           => $tgl_masuk,
                'keterangan'        => 'Laporan telah diselesaikan dengan baik'
            ]);

            DB::table('laporan')
            ->where('id', $idlap)
            ->update([
                'lap_no_ref'        => $lap_no_ref
            ]);
        } else if ($action == 'reject') {
            Laporanhist::create([
                'id_laporan'        => $idlap,
                'status_laporan'    => 'Dibatalkan',
                'tanggal'           => $tgl_masuk,
                'keterangan'        => $request->keterangan
            ]);
        }

        return redirect('comp');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('pelapor.password');
    }

    public function ubahpassword(Request $request)
    {
        if(!Hash::check($request->old_password, Auth::guard('pelapor')->user()->password)) {
            return back()->with('error', 'Password Lama Tidak Sesuai');
        }

        if($request->new_password != $request->re_password){
            return back()->with('error', 'Password Baru dan Pengulangan Password Tidak Sama');
        }

        Pelapor::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password Baru Berhasil Dibuat');


        // dd(Pelapor::whereId(auth()->user()->id));
        
        // return view('pelapor.password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tambahwaktu(Request $request, $idlap)
    {
        $action     = $request->input('action');
        $tgl_masuk  = Carbon::now()->format('Y-m-d H:i:s');
    

        if ($action === 'accept') {
            $lap = DB::table('laporan')->where('id', $idlap)->first();
            $waktu_tambahan = $lap->waktu_tambahan;
            $waktu_tambahan = $waktu_tambahan + $request->waktu_tambahan_peng;

            Laporanhist::create([
                'id_laporan'        => $idlap,
                'status_laporan'    => 'Diproses',
                'tanggal'           => $tgl_masuk,
                'keterangan'        => 'Penambahan waktu diterima'
            ]);

            DB::table('laporan')
            ->where('id', $idlap)
            ->update([
                'waktu_tambahan'        => $waktu_tambahan,
                'waktu_tambahan_peng'   => DB::raw('NULL')
            ]);

        } elseif ($action === 'reject') {
            $lap = DB::table('laporan')->where('id', $idlap)->first();
            $waktu_tambahan_peng = $lap->waktu_tambahan_peng;
            $keterangan = 'Pengajuan waktu tambahan ' . $waktu_tambahan_peng . ' hari ditolak dengan keterangan pelapor ( ' . $request->keterangan. ' )';

            DB::table('laporan')
            ->where('id', $idlap)
            ->update([
                'waktu_tambahan_peng'   => 0
            ]);

            Laporanhist::create([
                'id_laporan'        => $idlap,
                'status_laporan'    => 'Diproses',
                'tanggal'           => $tgl_masuk,
                'keterangan'        => $keterangan
            ]);
        } 

        // dd($keterangan);

        return redirect('comp');
    }

    public function edit ($id)
    {
        $lap = DB::table('laporan')
        ->where('id',$id)
        ->first();

        $detlap = DB::table('detlaporan')
        ->where('id_laporan',$id)
        ->get();

        // dd($detlap);

        return view('pelapor.comp-edit', compact('lap','detlap'));
    }

    public function updateLap (Request $request, $id)
    {
        // KONVERSI TANGGAL AWAL DAN AKHIR PENGERJAAN
        $tgl_awal = $request->tgl_awal;
        $waktu_awal = $request->waktu_awal;
        $tgl_akhir = $request->tgl_akhir;
        $waktu_akhir = $request->waktu_akhir;

        $tgl_awal_pengerjaan = Carbon::createFromFormat('d/m/Y H:i', $tgl_awal . ' ' . $waktu_awal)->format('Y-m-d H:i:s');
        $tgl_akhir_pengerjaan = Carbon::createFromFormat('d/m/Y H:i', $tgl_akhir . ' ' . $waktu_akhir)->format('Y-m-d H:i:s');
        // END KONVERSI TANGGAL AWAL DAN AKHIR PENGERJAAN

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'no_inv_aset' => $request->no_inv_aset,
            'tgl_awal_pengerjaan' => $tgl_awal_pengerjaan,
            'tgl_akhir_pengerjaan' => $tgl_akhir_pengerjaan,
        ]);

        // Update atau Tambah Detil Laporan
        if (count($request->kat_layanan) > 0) {
            foreach ($request->kat_layanan as $key => $value) {
                $jenis_layanan = $request->jenis_layanan[$key];
                $layanan_lain = isset($request->layanan_lain[$key]) ? $request->layanan_lain[$key] : null;

                $detLaporanData = [
                    'kat_layanan' => $request->kat_layanan[$key],
                    'jenis_layanan' => $jenis_layanan == 'Lainnya' ? $layanan_lain : $jenis_layanan,
                    'det_layanan' => $request->det_layanan[$key],
                ];

                // Cek apakah ID Detil Laporan ada untuk menentukan update atau insert
                if (isset($request->det_laporan_id[$key])) {
                    // Update existing detil laporan
                    $detLaporan = DetLaporan::findOrFail($request->det_laporan_id[$key]);
                    $detLaporan->update($detLaporanData);
                } else {
                    // Create new detil laporan
                    $detLaporan = new DetLaporan($detLaporanData);
                    $detLaporan->id_laporan = $laporan->id;
                    $detLaporan->save();
                }
            }
        }

        return redirect('comp');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            ->join('teknisi','teknisi.id','=','laporan.id_teknisi')
            ->select(
                'laporan.id AS id',
                'no_inv_aset',
                'tgl_selesai',
                'waktu_tambahan','teknisi.nama as nama_teknisi',
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
                ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
                ->get();
        } else {
            if ($kat_layanan != null) {
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                ->join('detlaporan', 'detlaporan.id_laporan', '=', 'laporan.id')
                -> join('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
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
                    ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
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
                    ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
                    ->get();
                // dd($data);
            } else if ($tgl_masuk != null) {
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                -> join('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
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
                    ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
                    ->get();
                // dd($data); 
            } else if ($tgl_selesai != null) {
                $data = DB::table('laporan')
                ->join('laporanhist', 'laporanhist.id_laporan', '=', 'laporan.id')
                -> join('teknisi', 'teknisi.id', '=', 'laporan.id_teknisi')
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
                    ->where('laporan.id_pelapor', '=', Auth::guard('pelapor')->user()->id)
                    ->get();
                // dd($data);
            }
        }

        foreach ($data as $laporan) {
            $laporan->history = DB::table('laporanhist')
            ->where('id_laporan', $laporan->id)
            ->where('laporanhist.status_laporan', '!=', 'Manager') 
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
        return view('pelapor.history-u', compact('data', 'datas', 'filter', 'kat_layanan'));
    }

    public function laptidaksesuai(Request $request, $id)
    {
        // detail($id);
        $action = $request->action;
        $tgl_masuk  = Carbon::now()->format('Y-m-d H:i:s');

        $id_lap = DB::table('detlaporan')
            ->where('id', $id)
            ->first();

        if($action == 'accept'){
            DB::table('detlaporan')
                ->where('id', $id)
                ->update([
                    'acc_status'    => 'yes'
                ]);

            Laporanhist::create([
                'id_laporan'        => $id_lap->id_laporan,
                'status_laporan'    => 'Diproses', //cek pengajuan hapus laporan user
                'tanggal'           => $tgl_masuk,
                'keterangan'        => 'Penghapusan Permasalahan Diterima'
            ]);
        } else if($action == 'reject') {
            DB::table('detlaporan')
                ->where('id', $id)
                ->update([
                    'acc_status'    => 'no'
                ]);

            Laporanhist::create([
                'id_laporan'        => $id_lap->id_laporan,
                'status_laporan'    => 'Diproses', //cek pengajuan hapus laporan user
                'tanggal'           => $tgl_masuk,
                'keterangan'        => $request->keterangan
            ]);
        }

        return back();
    }
}
