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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('history-admin')}}" method="get" id="filterForm">
                        {{csrf_field()}}
                        <div class="form-row">
                            <div class="col-2">
                                <select id="filter" name="filter" class="form-control">
                                    <option value="" disabled selected>Pilih Filter</option>
                                    <option value="tgl_masuk">Tanggal Masuk</option>
                                    <option value="tgl_selesai">Tanggal Selesai</option>
                                    <option value="no_inv_aset">No Inventaris</option>
                                    <option value="kat_layanan">Kategori</option>
                                </select>
                            </div>
                            <div id="additional-filters"></div>
                            <div class="col">
                                @if($filter != null)
                                <button type="submit" name="action" value="filter" class="btn btn-primary">Filter</button>
                                <a href="/history-user"><button type="button" id="clearFilterBtn" class="btn btn-primary">Show All Data</button></a>
                                @else
                                <button type="submit" name="action" value="filter" class="btn btn-primary">Filter</button>
                                <button type="button" id="clearFilterBtn" class="btn btn-primary">Clear</button>
                                @endif
                            </div>
                        </div>
                        <!-- @if($kat_layanan != null)
                        <br>
                        {{$kat_layanan}}
                        @endif -->
                    </form>
                </div>
            </div>
        </div>
        @if($datas == 'ada')
        <div class="col-12">
            @foreach($data as $dt)
            <div class="card text-left" style="color: #4F4B4B;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            Tanggal <br><br>
                            <b>Tanggal Kirim</b><br>
                            {{$dt->tgl_masuk}}<br><br>
                            <b>Tanggal Selesai</b><br>
                            {{$dt->tgl_selesai}}
                        </div>
                        <div class="col">
                            Nomor Referensi <br><br>
                            @if($dt->lap_no_ref == null)
                            <b><i>Belum ada</i></b>
                            @else
                            <b>{{$dt->lap_no_ref}}</b>
                            @endif
                        </div>
                        <div class="col">
                            No Inventaris <br><br>
                            <b>{{$dt->no_inv_aset}}</b>
                        </div>
                        @if($kat_layanan != null)
                        <div class="col">
                            Kategori / Jenis Layanan <br><br>
                            <b>{{$dt->kat_layanan}} / {{$dt->jenis_layanan}}</b>
                        </div>
                        @endif
                        <div class="col">
                            Nama Teknisi <br><br>
                            <b>{{$dt->nama_teknisi}}</b>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{url('detail-comp',$dt->id)}}"><button class="btn mb-1 btn-outline-primary">Detail</button></a>
                    <button type="button" class="btn mb-1 btn-outline-primary" data-toggle="modal" data-target="#basicModal{{$dt->id}}">History</button>
                </div>

                <!-- ============= MODAL HISTORY USER ============= -->
                <div class="modal fade" id="basicModal{{$dt->id}}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Permintaan Layanan</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @foreach($dt->history as $dthist)
                                <table>
                                    <tr>
                                        <td style="width: 90px; margin-right: 100px;" rowspan="2" valign=top align="right">
                                            @if($dthist->status_laporan == 'Pengajuan')
                                            <span class="badge badge-primary">Open</span>
                                            @elseif($dthist->status_laporan == 'Diproses' or $dthist->status_laporan == 'reqAddTime' or $dthist->status_laporan == 'CheckLapU' or $dthist->status_laporan == 'CheckedU' )
                                            <span class="badge badge-info">Process</span>
                                            @elseif($dthist->status_laporan == 'Selesai')
                                            <span class="badge badge-success">Closed</span>
                                            @elseif($dthist->status_laporan == 'Dibatalkan')
                                            <span class="badge badge-danger">Cancel</span>
                                            @elseif($dthist->status_laporan == 'ReqHapus')
                                            <span class="badge badge-warning">Request <i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                            @endif
                                        </td>
                                        <td style="width: 10px;"></td>
                                        <td style="color: black;">{{$dthist->tanggal}}</td>
                                    </tr>
                                    <tr style="height: 30px;">
                                        <td style="width: 10px;"></td>
                                        <td style="font-size: 12px;" valign=top>
                                            @if($dthist->keterangan != null)
                                            @if($dthist->status_laporan == 'reqAddTime')
                                            Pengajuan penambahan waktu -
                                            @endif
                                            {{$dthist->keterangan}}
                                            @else
                                            <i>tidak ada keterangan</i>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============= MODAL HISTORY USER ============= -->
            </div>
            @endforeach
        </div>
        @else
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 style="text-align: center;">Maaf, Data Tidak Ditemukan</h5>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filter').change(function() {
            var filter = $(this).val();
            $('#additional-filters').empty();
            switch (filter) {
                case 'tgl_masuk':
                    $('#additional-filters').append('<select id="condition" name="tgl_masuk_f" class="form-control"><option value="<=">Sebelum</option><option value=">=">Sesudah</option></select>');
                    $('#additional-filters').append('<input type="date" id="date" name="tgl_masuk" class="form-control">');
                    break;
                case 'tgl_selesai':
                    $('#additional-filters').append('<select id="condition" name="tgl_selesai_f" class="form-control"><option value="<=">Sebelum</option><option value=">=">Sesudah</option></select>');
                    $('#additional-filters').append('<input type="date" id="date" name="tgl_selesai" class="form-control">');
                    break;
                case 'no_inv_aset':
                    $.ajax({
                        url: '/getNoInventarisOptionsAdmin',
                        type: 'GET',
                        success: function(response) {
                            $('#additional-filters').append('<select id="no_inv_aset" name="no_inv_aset" class="form-control">' + response.options + '</select>');
                        }
                    });
                    break;
                case 'kat_layanan':
                    $('#additional-filters').append('<select id="condition" name="kat_layanan" class="form-control"><option value="Throubleshooting">Throubleshooting</option><option value="Instalasi">Instalasi</option>');
                    break;
                default:
                    break;
            }
        });
    });
    $(document).ready(function() {
        // Tangani klik tombol "Clear Filter"
        $('#clearFilterBtn').click(function() {
            // Bersihkan nilai input dan pilihan dropdown filter
            $('#filterForm')[0].reset(); // Bersihkan formulir filter
            $('#additional-filters').empty(); // Kosongkan div tambahan untuk filter tambahan
        });
    });
</script>

@endsection