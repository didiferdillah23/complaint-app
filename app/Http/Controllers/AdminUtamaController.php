<?php

namespace App\Http\Controllers;

use App\Models\LogAktivasi;
use App\Models\Teknisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminUtamaController extends Controller
{
    public function showAktivasiAkun(Request $request)
    {
        $active_tab = $request->active_tab??'teknisi';
        $where_condition = $active_tab == 'teknisi' ? 'App\Models\Teknisi' : 'App\Models\Pengawas';

        // $users = LogAktivasi::with('relatable')->where('relatable_type', $where_condition)->get();
        $users = Teknisi::with('logAktivasi')->get();

        return view('admin_utama.akun', [
            'active_tab' => $active_tab,
            'users' => $users
        ]);  
    }

    public function formPengajuanAktivasi()
    {
        if(auth()->guard('teknisi')->user()->limit_trial >= Carbon::now()->format('Y-m-d') && auth()->guard('teknisi')->user()->limit_trial != NULL) {
            return "Halaman tidak dapat diakses, akun anda sudah diaktivasi!";
        }

        $user = auth()->user();
        $aktivasi = LogAktivasi::where('relatable_id', $user->id)->first();
        
        return view('form_pengajuan_aktivasi', [
            'user' => $user,
            'aktivasi' => $aktivasi
        ]);
    }

    public function submitAktivasi()
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();

            if(auth()->guard('teknisi')->check()) {
                $user_type = 'App\Models\Teknisi';
            }
            
            if(auth()->guard('pengawas')->check()) {
                $user_type = 'App\Models\Pengawas';
            }

            LogAktivasi::create([
                'relatable_id' => $user->id,
                'relatable_type' => $user_type,
                'persetujuan_pengawas' => 'pengajuan',
            ]);

            DB::commit();

            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function aktivasi($userId)
    {
        $user = Teknisi::find($userId);

        // create log aktivasi
        $log = LogAktivasi::create([
            'relatable_id' => $user->id,
            'relatable_type' => 'App\Models\Teknisi',
            'status_aktivasi' => 1,
            'kode_aktivasi' => '-'
        ]);

        do {
            $kode_aktivasi = \Str::upper(\Str::random(10));
        } while (LogAktivasi::where('kode_aktivasi', $kode_aktivasi)->exists());

        $log->update(['kode_aktivasi' => $kode_aktivasi]);

        // $data = [
        //     'firstname' => 'Admin Utama',
        //     'nama_teknisi' => $user->relatable->nama,
        //     'kode_aktivasi' => $user->kode_aktivasi
        // ];
        // \Mail::send('template-email-aktivasi', $data, function($message)
        // {
        //     $message->to('raisusmanadzikri@gmail.com', 'Pak Usman')->subject('Kode Aktivasi');
        // });

        return redirect()->back();
    }

    public function postAktivasi(Request $request,$userId)
    {
        $user = Teknisi::find($userId);

        if(LogAktivasi::where('kode_aktivasi', $request->code)->where('relatable_id', $user->id)->where('relatable_type', 'App\Models\Teknisi')->first() == NULL) {
            $msg = 'Kode aktivasi tidak valid!';
            Session::flash('warning', $msg); 

            return redirect()->back();
        }

        $user->update([
            'status_aktivasi' => 1,
            'kode_aktivasi' => $request->code
        ]);

        $msg = 'Berhasil melakukan aktivasi!';
        Session::flash('success', $msg);

        return redirect()->back();
    }

    public function submitKodeAktivasi(Request $request)
    {
        $request->validate([
            'kode_aktivasi' => 'required'
        ]);

        $user = auth()->user();

        $pengajuan = LogAktivasi::where('kode_aktivasi', $request->kode_aktivasi)->first();

        if($pengajuan == NULL) {
            $msg = 'Kode aktivasi tidak valid!';
            Session::flash('warning', $msg); 

            return redirect()->back();
        }
        
        if(auth()->guard('teknisi')->check()) {
            $user_type = 'App\Models\Teknisi';
        }
        
        if(auth()->guard('pengawas')->check()) {
            $user_type = 'App\Models\Pengawas';
        }

        if($user_type == $pengajuan->relatable_type && $user->id == $pengajuan->relatable_id) {
            $user->status_aktivasi = 1;
            $user->kode_aktivasi = $request->kode_aktivasi;
            $user->save();
        } else {
            $msg = 'Kode aktivasi tidak valid!';
            Session::flash('warning', $msg); 

            return redirect()->back();
        }

        $msg = 'Aktivasi berhasil.';
        Session::flash('success', $msg); 

        return redirect()->back();

    }

}
