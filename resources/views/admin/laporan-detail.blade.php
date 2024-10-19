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
            <li class="breadcrumb-item"><a href="javascript:history.back()">Laporan</a></li>
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
                                @elseif($laporan->status_terakhir == 'Dibatalkan')
                                <span class="badge badge-danger">Cancel</span>
                                @endif
                            </td>
                        </tr>
                        @if($laporan->status_terakhir == 'reqAddTime')
                        <tr>
                            <td style="width: 150px; height: 50px;" valign="top">Detail Status</td>
                            <td style="width: 15px;" valign="top">:</td>
                            <td style="height: 80px;" valign="top">Menunggu persetujuan penambahan waktu oleh Pelapor</td>
                        </tr>
                        @elseif($laporan->status_terakhir == 'CheckedU')
                        <tr>
                            <td style="width: 150px; height: 50px;" valign="top">Detail Status</td>
                            <td style="width: 15px;" valign="top">:</td>
                            <td style="height: 80px;" valign="top">Menunggu persetujuan penyelesaian laporan dari Teknisi ke Pelapor</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="width: 150px; height: 25px;">Tanggal Pelaporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->tgl_masuk}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Nama Pelapor</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->nama_pelapor}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Jabatan Pelapor</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->jabatan_pelapor}}</td>
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
                    </table> <br>
                    @if($laporan->status_terakhir == 'Selesai')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$laporan->id}}" data-whatever="@getbootstrap">Laporan</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal{{$laporan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{route('manager',$laporan->id)}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-content">
                        <!-- <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div> -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nomor Referensi</label>
                                <input name="lap_no_ref" type="text" class="form-control" readonly value="{{$nomorReferensi}}">
                            </div>
                            <div class="form-group">
                                <label>Nomor Laporan</label>
                                <input name="lap_nomor" type="text" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input name="lap_tanggal" type="date" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Versi</label>
                                <input name="lap_versi" type="text" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Halaman</label>
                                <input name="lap_halaman" type="text" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Bisnis Area</label>
                                <input name="lap_bisnis_area" type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send to Manager</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 col-xl-7">
            <?php $no = 0; ?>
            @foreach($detlaporan as $dtl)
            <?php $no++ ?>
            <div class="card">
                <div class="card-body">
                    <b>Laporan {{$no}}</b><br><br>
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
                        @if($dtl->det_pekerjaan != null && $dtl->ket_pekerjaan != null)
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
                        @endif
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection