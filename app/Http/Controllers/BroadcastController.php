<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; 


class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bc = DB::table('broadcast')
        ->select([
            'judul','informasi','status','id',
            DB::raw("DATE_FORMAT(tgl_tampil, '%d %M %Y, %H:%i WIB') AS tgl_tampil"),
            DB::raw("DATE_FORMAT(tgl_selesai, '%d %M %Y, %H:%i WIB') AS tgl_selesai"),
        ])
        ->get();
        return view('Admin.broadcast', compact('bc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.broadcast-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $judul          = $request->judul;
        $informasi      = $request->informasi;
        $tgl_tampil     = $request->tgl_tampil;
        $waktu_tampil   = $request->waktu_tampil;
        $tgl_selesai    = $request->tgl_selesai;
        $waktu_selesai  = $request->waktu_selesai;

        $tgl_tampil_broadcast   = Carbon::createFromFormat('d/m/Y H:i', $tgl_tampil . ' ' . $waktu_tampil)->format('Y-m-d H:i:s');
        $tgl_selesai_broadcast  = Carbon::createFromFormat('d/m/Y H:i', $tgl_selesai . ' ' . $waktu_selesai)->format('Y-m-d H:i:s');

        Broadcast::create([
            'judul'         => $judul,
            'informasi'     => $informasi,
            'tgl_tampil'    => $tgl_tampil_broadcast,
            'tgl_selesai'   => $tgl_selesai_broadcast
        ]);

        $msg = 'Broadcast Berhasil Dibuat';
        Session::flash('success',$msg); 

        // dd($tgl_tampil_broadcast, $tgl_selesai_broadcast);
        return redirect('/broadcast');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bc = DB::table('broadcast')
        ->where('id', $id)
        ->first();

        return view('Admin.broadcast-edit', compact('bc'));

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
        $judul          = $request->judul;
        $informasi      = $request->informasi;
        $tgl_tampil     = $request->tgl_tampil;
        $waktu_tampil   = $request->waktu_tampil;
        $tgl_selesai    = $request->tgl_selesai;
        $waktu_selesai  = $request->waktu_selesai;

        $tgl_tampil_broadcast   = Carbon::createFromFormat('d/m/Y H:i', $tgl_tampil . ' ' . $waktu_tampil)->format('Y-m-d H:i:s');
        $tgl_selesai_broadcast  = Carbon::createFromFormat('d/m/Y H:i', $tgl_selesai . ' ' . $waktu_selesai)->format('Y-m-d H:i:s');

        DB::table('broadcast')
        ->where('id', $id)
        ->update([
            'judul'         => $judul,
            'informasi'     => $informasi,
            'tgl_tampil'    => $tgl_tampil_broadcast,
            'tgl_selesai'   => $tgl_selesai_broadcast
        ]);

        $msg = 'Broadcast Berhasil Diperbarui';
        Session::flash('success', $msg); 

        return redirect('/broadcast');
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
