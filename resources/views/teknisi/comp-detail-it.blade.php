@extends('template')
@section('style')
<style>
    .garis_verikal {
        border-left: 2px #F54D4D solid;
        height: 20px;
        width: 0px;
        margin-left: 70px;
    }

    .error {
        color: red;
        font-size: 0.875em;
    }
</style>
@endsection
@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:history.back()">Daftar Laporan</a></li>
            <li class="breadcrumb-item active"><a>Detail</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-xl-6">
            <div class="card">
                @if(Session::has('success'))
                <div class="toastr-trigger" data-type="success" data-message="Waktu Tambahan di Reset" data-position-class="Berhasil"></div>
                @endif
                @if(Session::has('failed'))
                <div class="toastr-trigger" data-type="error" data-message="Kategori Layanan dan Jenis Layanan Sudah Ada" data-position-class="Gagal"></div>
                @endif
                @if(Session::has('hapus'))
                <div class="toastr-trigger" data-type="success" data-message="Permasalahan Tambahan Dihapus" data-position-class="Berhasil"></div>
                @endif
                <div class="card-body">
                    <table style="color: #2D3134;">
                        <tr>
                            <td style="width: 136px; height: 25px;">Status</td>
                            <td style="width: 15px;">:</td>
                            <td>
                                @if($laporan->status_terakhir == 'Pengajuan')
                                <span class="badge badge-primary">Open</span>
                                @elseif($laporan->status_terakhir == 'Diproses')
                                <span class="badge badge-info">Process</span>
                                @elseif($laporan->status_terakhir == 'reqAddTime' or $laporan->status_terakhir == 'CheckLapU' or $laporan->status_terakhir == 'CheckedU')
                                <span class="badge badge-warning" data-toggle="tooltip" data-placement="right" title="Persetujuan tambah waktu">Postponed</span>
                                @elseif($laporan->status_terakhir == 'Selesai')
                                <span class="badge badge-success">Closed</span>
                                @elseif($laporan->status_terakhir == 'Manager')
                                <span class="badge badge-success">Manager</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 136px; height: 25px;">Nama Pelapor</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->nama_pelapor}}</td>
                        </tr>
                        <tr>
                            <td style="width: 136px; height: 25px;">Jabatan Pelapor</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->jabatan_pelapor}}</td>
                        </tr>
                        <tr>
                            <td style="width: 136px; height: 25px;">Tanggal Pelaporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->tgl_masuk}}</td>
                        </tr>
                        @if($laporan->tgl_selesai != null)
                        <tr>
                            <td style="width: 136px; height: 25px;">Tanggal Selesai</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->tgl_selesai}}</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="width: 136px; height: 25px;">No Inventaris Aset</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$laporan->no_inv_aset}}</td>
                        </tr>
                        <tr valign="top">
                            <td style="width: 136px; height: 25px;">Periode Pengerjaan</td>
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
                            <td style="width: 136px; height: 25px;" valign='top'>Waktu Tambahan</td>
                            <td style="width: 15px;" valign='top'>:</td>
                            @if($laporan->waktu_tambahan != null)
                            <td valign='top'>{{$laporan->waktu_tambahan}} hari</td>
                            @elseif($laporan->waktu_tambahan_peng != null)
                            <td valign='top'>{{$laporan->waktu_tambahan_peng}} hari <span style="color: #DD0B2E;">(pengajuan)</span></td>
                            @elseif($laporan->waktu_tambahan_peng == '0' && $laporan->status_terakhir != 'Selesai')
                            <td valign='top'>
                                {{$laporan->keterangan}}
                            </td>
                            @elseif($laporan->waktu_tambahan == null)
                            <td>
                                -
                            </td>
                            @endif
                        </tr>
                        @if($laporan->waktu_tambahan_peng == 0)
                        <tr>
                            <td></td>
                        </tr>
                        @endif
                    </table>
                    <br>

                    <!-- 1 -->
                    @if($laporan->status_terakhir != 'Selesai' && $laporan->status_terakhir != 'Manager')
                    <!-- 2 -->
                    @if($laporan->status_terakhir == 'Pengajuan')
                    <form action="{{route('proses-laporan',$laporan->id)}}" method="post">
                        {{csrf_field()}}
                        <button class="btn btn-primary" type="submit" name="action" value="process">Proses</button>
                        <!-- <button class="btn btn-primary" type="submit" name="action" value="process">Proses</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$laporan->id}}" data-whatever="@getbootstrap">Tolak</button> -->
                    </form>
                    @endif
                    <!-- end 2 -->
                    <!-- 3 -->
                    @if($laporan->waktu_tambahan_peng == null && $laporan->status_terakhir != 'Pengajuan' && $laporan->status_terakhir != 'CheckedU' && $laporan->status_terakhir != 'reqAddTime')
                    <div class="button-group">
                        <div class="btn-toolbar">
                            <div class="btn-group mr-2 mb-2">
                                <button type="button" class="btn btn-secondary">Waktu</button>
                                <button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal1{{$laporan->id}}" data-whatever="@getbootstrap"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <!-- 4 -->
                                @if(strtotime($laporan->deadline) > strtotime(now()) && $laporan->waktu_tambahan != null)
                                <form action="{{route('reset-waktu',$laporan->id)}}" method="post">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Reset Waktu Tambahan" onclick="confirm('Apakah yakin mereset tambahan waktu?')"><i class="fa fa-refresh" aria-hidden="true" onclick="confirm('Apakah anda yakin akan reset waktu?')"></i></button>
                                </form>
                                @endif
                                <!-- end 4 -->
                            </div>
                            <div class="btn-group mr-2 mb-2">
                                <button type="button" class="btn btn-secondary">Laporan</button>
                                <button class="btn btn-secondary" type="submit" data-toggle="modal" data-target="#exampleModalLaporan{{$laporan->id}}" data-whatever="@getbootstrap"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                @if($count <= 0)
                                <button class="btn btn-secondary" type="submit" data-toggle="modal" data-target="#exampleModalSelesai{{$laporan->id}}" data-whatever="@getbootstrap"><i class="fa fa-check" aria-hidden="true"></i></button>
                                @endif 
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- end 3 -->
                    @endif
                    <!-- end 1 -->

                    <!-- ========= MODAL TAMBAH LAPORAN ========= -->
                    <div class="modal fade" id="exampleModalLaporan{{$laporan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{route('tambah-pekerjaan-it',$laporan->id)}}" method="POST">
                                {{csrf_field()}}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Permasalahan Laporan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Kategori Laporan</label>
                                            <select required name="kat_layanan" class="form-control" id="kat_layanan">
                                                <option value="" selected>Pilih satu</option>
                                                <option value="Throubleshooting">Throubleshooting</option>
                                                <option value="Instalasi">Instalasi</option>
                                            </select>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <label>Jenis Layanan</label>
                                                <select required name="jenis_layanan" class="form-control" id="jenis_layanan">
                                                </select>
                                            </div>
                                            <div class="col" id="layanan_lain_group" style="display: none;">
                                                <label>Lainnya</label>
                                                <input type="text" name="layanan_lain" class="form-control" placeholder="Jenis Layanan Lainnya">
                                            </div>
                                        </div><br>
                                        <div class="form-group">
                                            <label>Permasalahan</label>
                                            <textarea name="det_layanan" class="form-control" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Detail Pekerjaan</label>
                                            <textarea name="det_pekerjaan" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan Pekerjaan</label>
                                            <textarea name="ket_pekerjaan" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ========= END MODAL TAMBAH LAPORASELESAIN ========= -->

                    <!-- ========= MODAL  ========= -->
                    <div class="modal fade" id="exampleModalSelesai{{$laporan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{route('laporan-selesai-it',$laporan->id)}}" method="POST">
                                {{csrf_field()}}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Selesaikan Laporan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Bisnis Area:</label>
                                            <input type="text" id="lap_bisnis_area" name="lap_bisnis_area" class="form-control" oninput="validateInput(this)" required>
                                            <div id="error-message" class="error"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ========= END MODAL SELESAI ========= -->

                    <!-- ========= MODAL ALASAN PENOLAKAN ========= -->
                    <div class="modal fade" id="exampleModal{{$laporan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{route('proses-laporan',$laporan->id)}}" method="post">
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

                </div>
            </div>
        </div>
        <!-- ========= MODAL PENAMBAHAN WAKTU ========= -->
        <div class="modal fade" id="exampleModal1{{$laporan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{route('tambah-waktu',$laporan->id)}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Waktu Pengerjaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Penambahan waktu:</label>
                                <div class="input-group mb-3">
                                    <input name="waktu_tambahan" style="width: 70px;" type="number" class="form-control" min="1">
                                    <div class="input-group-prepend"><span class="input-group-text">hari</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Keterangan:</label>
                                <textarea name="keterangan" style="height: 100px;" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- ========= END MODAL PENAMBAHAN WAKTU ========= -->

        <!-- ========= CARD DETAIL LAPORAN ========= -->
        <div class="col-lg-6 col-xl-6">
            <?php $no = 0; ?>
            @foreach($detlaporan as $dtl)
            <?php $no++ ?>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mr-auto p-2 bd-highlight">
                            <!-- {{$dtl->id_det}} -->
                            <table>
                                <tr>
                                    <td style="width: 143px; color: #2D3134 ;"><b>Permasalahan {{$no}}</b></td>
                                    <td style="color: red;">
                                        @if($dtl->det_pekerjaan == null && $dtl->ket_pekerjaan == null)
                                        | Belum Diisi
                                        @elseif($dtl->acc_status == 'waiting')
                                        | Permasalahan akan Terhapus
                                        @elseif($dtl->acc_status == 'no')
                                        | Pengajuan Hapus Laporan Ditolak
                                        @elseif($dtl->acc_status == 'yes')
                                        | Permasalahan Terhapus
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        @if($dtl->status_terakhir != 'Selesai' && $dtl->status_terakhir != 'Pengajuan')
                        <div class="p-2 bd-highlight">
                            <table>
                                <tr>
                                    @if($dtl->acc_status != 'yes')
                                    <td style="width: 20px;">
                                        <i style="color: #3167D5; cursor: pointer;" type="button" data-toggle="modal" data-target="#exampleModalP{{$dtl->id_det}}" data-whatever="@getbootstrap" class="fa fa-pencil-square-o"></i>
                                    </td>
                                    @endif
                                    @if($dtl->id_teknisi != null)
                                    <td>
                                        <a href="{{url('hapus-pekerjaan-it',$dtl->id_det)}}" onclick="confirm('Apakah yakin menghapus laporan permasalahan ini?')"><i style="color: #DD0B2E; cursor: pointer;" type="button" class="fa fa-trash"></i></a>
                                        <!-- <i style="color: #DD0B2E; cursor: pointer;" type="button" data-toggle="modal" data-target="#exampleModalP{{$dtl->id_det}}" data-whatever="@getbootstrap" class="fa fa-trash"></i> -->
                                    </td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                        @endif
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
                        <tr valign="top">
                            <td style="width: 150px; height: 30px;">Detail Laporan</td>
                            <td style="width: 15px;">:</td>
                            <td>{{$dtl->det_layanan}}</td>
                        </tr>
                        @if($dtl->det_pekerjaan != null or $dtl->ket_pekerjaan != null)
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
                            <td style="width: 150px; height: 25px;" valign="top">Detail Pekerjaan</td>
                            <td style="width: 15px;" valign="top">:</td>
                            <td valign="top">{{$dtl->det_pekerjaan}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;" valign="top">Keterangan Pekerjaan</td>
                            <td style="width: 15px;" valign="top">:</td>
                            <td valign="top">{{$dtl->ket_pekerjaan}}</td>
                        </tr>
                        @if($dtl->acc_status == 'no')
                        <tr>
                            <td style="width: 150px; height: 25px;">
                                <b>Pelapor</b>
                            </td>
                            <td style="width: 15px;"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 25px;" valign="top">Alasan Penolakan</td>
                            <td style="width: 15px;" valign="top">:</td>
                            <td valign="top">{{$laporan->keterangan}}</td>
                        </tr>
                        @endif
                        @endif
                    </table>
                </div>
            </div>
            @endforeach
        </div>
        <!-- ========= CARD DETAIL LAPORAN ========= -->

        <!-- ========= MODAL DETAIL DAN KETERANGAN PEKERJAAN ========= -->
        @foreach($detlaporan as $dtl2)
        <div class="modal fade" id="exampleModalP{{$dtl2->id_det}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{route('detail-pekerjaan-it',$dtl2->id_det)}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Input Penyelesaian Permasalahan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <table style="color: #2D3134;">
                                <tr>
                                    <td style="width: 170px; height: 25px;">Kategori Laporan</td>
                                    <td style="width: 15px;">:</td>
                                    <td>{{$dtl2->kat_layanan}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 170px; height: 25px;">Jenis Laporan</td>
                                    <td style="width: 15px;">:</td>
                                    <td>{{$dtl2->jenis_layanan}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 170px; height: 35px;" valign="top">Laporan Permasalahan</td>
                                    <td style="width: 15px;" valign="top">:</td>
                                    <td valign="top">{{$dtl2->det_layanan}}</td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <table style="width: 100%; color: #2D3134;">
                                    <tr>
                                        <td style="width: 50%; height:40px">Detail Pekerjaan:</td>
                                        @if($dtl2->id_teknisi == null)
                                        <td align="right" style="width: 50%; height:40px">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="tidak sesuai" id="status{{$dtl2->id_det}}" name="status" onchange="toggleDetailPekerjaan({{$dtl2->id_det}})"> Perbaikan Tidak Sesuai
                                                </label>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                </table>
                                <textarea name="det_pekerjaan" required class="form-control" id="det_pekerjaan{{$dtl2->id_det}}" data-initial-value="{{$dtl2->det_pekerjaan}}">{{$dtl2->det_pekerjaan}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Keterangan Pekerjaan:</label>
                                <textarea name="ket_pekerjaan" class="form-control" id="ket_pekerjaan{{$dtl2->id_det}}">{{$dtl2->ket_pekerjaan}}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
        <!-- ========= END MODAL DETAIL DAN KETERANGAN PEKERJAAN ========= -->
    </div>
</div>
@endsection
@section('script')
<script>
    function validateInput(input) {
        const invalidChars = /[.\\/:*?"<>|]/g;
        const errorMessage = document.getElementById('error-message');

        if (invalidChars.test(input.value)) {
            errorMessage.textContent = 'Input tidak boleh mengandung karakter berikut: \\ / : * ? " < > |';
            input.value = input.value.replace(invalidChars, '');
        } else {
            errorMessage.textContent = '';
        }
    }

    function validateForm() {
        const input = document.getElementById('lap_bisnis_area').value;
        const invalidChars = /[\\/:*?"<>|]/;
        const errorMessage = document.getElementById('error-message');

        if (invalidChars.test(input)) {
            errorMessage.textContent = 'Input tidak boleh mengandung karakter berikut: \\ / : * ? " < > |';
            return false;
        }

        return true;
    }

    function toggleDetailPekerjaan(id) {
        var statusCheckbox = document.getElementById('status' + id);
        var detPekerjaanTextarea = document.getElementById('det_pekerjaan' + id);
        var ketPekerjaanTextarea = document.getElementById('ket_pekerjaan' + id);

        if (statusCheckbox.checked) {
            detPekerjaanTextarea.value = "Perbaikan tidak sesuai";
            detPekerjaanTextarea.disabled = true;
            ketPekerjaanTextarea.required = true;
        } else {
            var initialValue = detPekerjaanTextarea.getAttribute('data-initial-value');
            detPekerjaanTextarea.value = initialValue;
            detPekerjaanTextarea.disabled = false;
            ketPekerjaanTextarea.required = false;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var katLayanan = document.getElementById('kat_layanan');
        var jenisLayanan = document.getElementById('jenis_layanan');
        var layananLainGroup = document.getElementById('layanan_lain_group');

        var optionsThroubleshooting = ["Aplikasi", "Jaringan", "PC/Laptop", "Printer", "Lainnya"];
        var optionsInstalasi = ["Aplikasi", "Sistem Operasi", "Jaringan", "PC/Laptop", "Printer", "Lainnya"];

        katLayanan.addEventListener('change', function() {
            var selectedCategory = this.value;
            jenisLayanan.innerHTML = '';

            var options = [];
            if (selectedCategory === 'Throubleshooting') {
                options = optionsThroubleshooting;
            } else if (selectedCategory === 'Instalasi') {
                options = optionsInstalasi;
            }

            options.forEach(function(option) {
                var opt = document.createElement('option');
                opt.value = option;
                opt.textContent = option;
                jenisLayanan.appendChild(opt);
            });
        });

        jenisLayanan.addEventListener('change', function() {
            if (this.value === 'Lainnya') {
                layananLainGroup.style.display = 'block';
            } else {
                layananLainGroup.style.display = 'none';
            }
        });
    });
</script>
@endsection