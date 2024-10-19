@extends('template')
@section('style')
<style>
    .garis_verikal {
        border-left: 2px #F54D4D solid;
        height: 20px;
        width: 0px;
        margin-left: 70px;
    }
</style>
@endsection
@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/list-laporan">Laporan</a></li>
            <li class="breadcrumb-item active"><a>Detail</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-xl-5">
            <div class="card">
                <div class="card-body">
                    <table style="color: #2D3134;">
                        <tr>
                            <td style="width: 150px; height: 25px;">Tanggal Pelaporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->tgl_masuk}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Nomor Referensi</td>
                            <td>:</td>
                            <td>{{$laporan->lap_no_ref}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Bisnis Area</td>
                            <td>:</td>
                            <td>{{$laporan->lap_bisnis_area}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Teknisi IT</td>
                            <td style="width: 15px;">:</td>
                            @if($laporan->id_teknisi != null)
                            <td>{{$laporan->nama}}</td>
                            @else
                            <td><i>Belum ada Teknisi</i></td>
                            @endif
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">No Inventaris Aset</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->no_inv_aset}}</td>
                        </tr>
                        <tr valign="top">
                            <td style="width: 150px; height: 25px;">Periode Pengerjaan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->tgl_awal_pengerjaan}}
                                <div class="garis_verikal"></div>
                                {{$laporan->tgl_akhir_pengerjaan}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Waktu Tambahan</td>
                            <td style="width: 15px;">:</td>
                            @if($laporan->waktu_tambahan != null)
                            <td>{{$laporan->waktu_tambahan}}</td>
                            @else
                            <td><i>-</i></td>
                            @endif
                        </tr>
                        <!-- <tr>
                            <td style="width: 150px; height: 25px;">Status</td>
                            <td style="width: 15px;">:</td>
                            <td>
                                @if($laporan->status_terakhir == 'Pengajuan')
                                <span class="badge badge-primary">Open</span>
                                @elseif($laporan->status_terakhir == 'Diproses')
                                <span class="badge badge-info">Diproses</span>
                                @elseif($laporan->status_terakhir == 'CheckedU')
                                <span class="badge badge-warning">User Check</span>
                                @elseif($laporan->status_terakhir == 'ReqHapus')
                                <span class="badge badge-warning">Request <i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                @elseif($laporan->status_terakhir == 'reqAddTime')
                                <span class="badge badge-warning">User Check</span>
                                @elseif($laporan->status_terakhir == 'Selesai')
                                <span class="badge badge-success">Closed</span>
                                @elseif($laporan->status_terakhir == 'Manager')
                                <span class="badge badge-success">Manager</span>
                                @endif
                            </td>
                        </tr> -->
                        <!-- <tr>
                            <td colspan="3" style="width: 150px; height: 25px;"><b>Detail Laporan</b></td>
                        </tr> -->
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-7">
            <?php $no = 0; ?>
            @foreach($detlaporan as $dtl)
            <?php $no++ ?>
            <div class="card">
                <div class="card-body">
                    <b style="color: #2D3134 ;">Laporan {{$no}}</b><br><br>
                    <table style="color: #2D3134;">
                        <tr>
                            <td>
                                <b>Pelapor</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Kategori Laporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$dtl->kat_layanan}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Jenis Laporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$dtl->jenis_layanan}}</td>
                        </tr>
                        <tr valign="top">
                            <td style="width: 150px; height: 35px;">Detail Laporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$dtl->det_layanan}}</td>
                        </tr>
                        <tr>
                            <td>
                                <b>Teknisi IT</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Detail Pekerjaan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$dtl->det_pekerjaan}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Keterangan Pekerjaan</td>
                            <td style="width: 15px;">:</td>
                            @if($dtl->ket_pekerjaan != null)
                            <td>{{$dtl->ket_pekerjaan}}</td>
                            @else
                            <td><i>Tidak ada keterangan</i></td>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection