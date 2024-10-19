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
                    @if($laporan->status_terakhir == 'reqAddTIme')
                    <h4>Pengajuan Penambahan Waktu</h4><br>
                    @elseif($laporan->status_terakhir == 'CheckedU')
                    <h4>Pengecekan Laporan</h4><br>
                    @endif
                    <table style="color: #2D3134;">
                        <tr>
                            <td style="width: 150px; height: 25px;">Status</td>
                            <td style="width: 15px;">:</td>
                            <td>
                                @if($laporan->status_terakhir == 'Pengajuan')
                                <span class="badge badge-primary">Open</span>
                                @elseif($laporan->status_terakhir == 'Diproses')
                                <span class="badge badge-info">Process</span>
                                @elseif($laporan->status_terakhir == 'CheckedU' or $laporan->status_terakhir == 'CheckLapU' or $laporan->status_terakhir == 'reqAddTime')
                                <span class="badge badge-warning">Postponed</span>
                                @elseif($laporan->status_terakhir == 'Selesai')
                                <span class="badge badge-success">Closed</span>
                                @elseif($laporan->status_terakhir == 'Manager')
                                <span class="badge badge-success">Closed</span>
                                @elseif($laporan->status_terakhir == 'Dibatalkan')
                                <span class="badge badge-danger">Cancel</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Tanggal Pelaporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->tgl_masuk}}</td>
                        </tr>
                        @if($laporan->tgl_selesai != null)
                        <tr>
                            <td style="width: 150px; height: 25px;">Tanggal Selesai</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->tgl_selesai}}</td>
                        </tr>
                        @endif
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
                                @if($laporan->waktu_tambahan != null)
                                <?php
                                $tanggalDeadline        = $laporan->deadline;
                                $waktu_tambahan         = $laporan->waktu_tambahan;
                                $tanggalBaruTimestamp   = strtotime(date('Y-m-d H:i', strtotime(str_replace('-', '/', $tanggalDeadline))) . " +$waktu_tambahan days");
                                $tanggalBaru_format     = date('d M Y', $tanggalBaruTimestamp) . ', ' . date('H:i', $tanggalBaruTimestamp) . ' WIB';
                                $tanggalBaru            = date('d-m-Y', $tanggalBaruTimestamp);
                                ?>
                                <!-- MENAMPILKAN TANGGAL BARU SETELAH PENAMBAHAN WAKTU -->
                                <span style="color: #3167D5;">{{ $tanggalBaru_format }}</span>
                                @else
                                {{ $laporan->tgl_akhir_pengerjaan }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 50px;" valign="top">Waktu Tambahan</td>
                            <td style="width: 15px;" valign="top">:</td>
                            @if($laporan->waktu_tambahan != null)
                            <td valign="top">{{$laporan->waktu_tambahan}} hari</td>
                            @else
                            <td valign="top">-</td>
                            @endif
                        </tr>
                        @if($laporan->waktu_tambahan_peng != null)
                        <tr>
                            <td style="width: 150px; height: 25px;"><b>Pengajuan Waktu</b></td>
                            <td style="width: 15px;"><b>:</b></td>
                            <td><b>{{$laporan->waktu_tambahan_peng}} hari</b></td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;" valign="top"><b>Keterangan</b></td>
                            <td style="width: 15px;" valign="top"><b>:</b></td>
                            <td valign="top"><b>{{$laporan->keterangan}}</b></td>
                        </tr>
                        @endif
                    </table><br>
                    @if($laporan->waktu_tambahan_peng != null)
                    <form action="{{route('proses-tambah-waktu',$laporan->idlap)}}" method="post">
                        {{csrf_field()}}
                        <input type="text" value="{{$laporan->waktu_tambahan_peng}}" hidden name="waktu_tambahan_peng">
                        <button class="btn btn-primary" type="submit" name="action" value="accept">Terima</button>
                        <!-- <button class="btn btn-danger" type="submit" name="action" value="reject">Tolak</button> -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal2{{$laporan->idlap}}" data-whatever="@getbootstrap">Tolak</button>
                    </form>
                    @endif
                    @if($laporan->status_terakhir == 'CheckedU')
                    <form action="{{route('acc-laporan',$laporan->idlap)}}" method="POST">
                        {{csrf_field()}}
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$laporan->idlap}}" data-whatever="@getbootstrap">Tolak</button>
                        <button class="btn btn-success" name="action" value="accept" type="submit" data-toggle="tooltip" data-placement="bottom" title="Laporan Selesai">Selesai</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- ========= MODAL ALASAN PENOLAKAN ========= -->
        <div class="modal fade" id="exampleModal{{$laporan->idlap}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{route('acc-laporan',$laporan->idlap)}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Alasan Penolakan:</label>
                                <textarea name="keterangan" style="height: 100px;" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="action" value="reject" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- ========= END MODAL ALASAN PENOLAKAN ========= -->

        <!-- ========= MODAL ALASAN PENOLAKAN PENAMBAHAN WAKTU ========= -->
        <div class="modal fade" id="exampleModal2{{$laporan->idlap}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{route('proses-tambah-waktu',$laporan->idlap)}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Alasan Penolakan Penambahan Waktu:</label>
                                <textarea name="keterangan" style="height: 100px;" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="action" value="reject" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- ========= END MODAL ALASAN PENOLAKAN PENAMBAHAN WAKTU ========= -->

        <div class="col-lg-6 col-xl-7">
            <?php $no = 0; ?>
            @foreach($detlaporan as $dtl)
            <?php $no++ ?>
            <div class="card">
                <div class="card-body">
                    <!-- {{$dtl->id}} -->
                    <div class="d-flex">
                        <div class="mr-auto p-2">
                            <table>
                                <tr>
                                    <td style="width: 143px; color: #2D3134 ;"><b>Permasalahan {{$no}}</b></td>
                                    <td style="color: red;">
                                        @if($dtl->acc_status == 'waiting')
                                        | Laporan Ditemukan Tidak Sesuai
                                        @elseif($dtl->acc_status == 'no')
                                        | Pengajuan Hapus Laporan Ditolak
                                        @elseif($dtl->acc_status == 'yes')
                                        | Permasalahan Terhapus
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="p-2">
                            @if($dtl->acc_status == 'waiting')
                            <form action="{{route('laptidaksesuai',$dtl->id)}}" method="post">
                                {{csrf_field()}}
                                <table>
                                    <tr>
                                        <td>
                                            <button class="btn btn-primary btn-sm" type="submit" name="action" value="accept"><i class="fa fa-check" aria-hidden="true"></i></button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalHapusLap{{$dtl->id}}" data-whatever="@getbootstrap"><i class="fa fa-times" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            @endif
                        </div>
                    </div>
                    <table style="color: #2D3134;">
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
                        <tr>
                            <td style="width: 150px; height: 25px;">Detail Laporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$dtl->det_layanan}}</td>
                        </tr>
                        @if($dtl->det_pekerjaan != null && $dtl->ket_pekerjaan != null)
                        <tr>
                            <td style="width: 150px; height: 25px;">
                                @if($dtl->acc_status == 'waiting')
                                <span style="color: #DD0B2E;">* </span>
                                @endif
                                <b>Teknisi IT</b>
                            </td>
                            <td style="width: 15px;"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Detail Pekerjaan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$dtl->det_pekerjaan}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;">Keterangan Pekerjaan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$dtl->ket_pekerjaan}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            @endforeach
        </div>

        <!-- ========= MODAL HAPUS LAPORAN ALASAN PENOLAKAN ========= -->
        @foreach($detlaporan as $dtl2)
        <div class="modal fade" id="exampleModalHapusLap{{$dtl2->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{route('laptidaksesuai',$dtl2->id)}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-content">
                        <div class="modal-body">
                            <!-- {{$dtl2->id}} -->
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Alasan Penolakan:</label>
                                <textarea name="keterangan" style="height: 100px;" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="action" value="reject" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
        <!-- ========= END MODAL HAPUS LAPORAN ALASAN PENOLAKAN ========= -->
    </div>
</div>
@endsection