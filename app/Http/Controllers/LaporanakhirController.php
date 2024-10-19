<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanakhirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idlap)
    {
        $no_ref         = $request->no_ref;
        $tanggal        = $request->tanggal;
        $bisnis_area    = $request->bisnis_area;
        $versi          = $request->versi;
        $halaman        = $request->halaman;
        $nomor          = $request->nomor;

        DB::table('laporanakhir')
        ->where('id_laporan', $idlap)
        ->update([
            'no_ref'        => $no_ref,
            'tanggal'       => $tanggal,
            'bisnis_area'   => $bisnis_area,
            'versi'         => $versi,
            'halaman'       => $halaman,
            'nomor'         => $nomor,
        ]);

        DB::table('laporan')
        ->where('id', $idlap)
        ->update([
            'id_pengawas'  => Auth::guard('pengawas')->user()->id
        ]);

        return redirect('list-laporan');
        // dd($request->all());

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
