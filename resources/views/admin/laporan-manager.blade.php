@extends('template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="color: #2D3134;" class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>Tanggal Permintaan</th>
                                    <th>Nama Pelapor</th>
                                    <th>No Inventaris</th>
                                    <th>Batas Akhir Pengerjaan</th>
                                    <th>Teknisi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dtLap as $data)
                                <tr>
                                    <td>{{ $data->tgl_masuk_f }}</td>
                                    <td>{{ $data->nama_pelapor }}</td>
                                    <td>{{ $data->no_inv_aset }}</td>
                                    <td>
                                        @if($data->waktu_tambahan != null)
                                        <?php
                                        $tanggalDeadline        = $data->deadline;
                                        $waktu_tambahan         = $data->waktu_tambahan;
                                        $tanggalBaruTimestamp   = strtotime(date('Y-m-d H:i', strtotime(str_replace('-', '/', $tanggalDeadline))) . " +$waktu_tambahan days");
                                        $tanggalBaru_format     = date('d M Y', $tanggalBaruTimestamp) . ', ' . date('H:i', $tanggalBaruTimestamp) . ' WIB';
                                        $tanggalBaru            = date('d-m-Y', $tanggalBaruTimestamp);
                                        ?>
                                        <!-- MENAMPILKAN TANGGAL BARU SETELAH PENAMBAHAN WAKTU -->
                                        <span style="color: #3167D5;">{{ $tanggalBaru_format }}</span>
                                        @else
                                        {{ $data->tgl_akhir_pengerjaan }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->id_teknisi != null)
                                        {{$data->nama_teknisi}}
                                        @else
                                        <i>Teknisi belum dipilih</i>
                                        @endif
                                    </td>

                                    <td>
                                        @if($data->status_terakhir == 'Pengajuan')
                                        <span class="badge badge-primary">Open</span>
                                        @elseif($data->status_terakhir == 'Diproses')
                                        <span class="badge badge-info">Diproses</span>
                                        @elseif($data->status_terakhir == 'CheckedU')
                                        <span class="badge badge-warning">User Check</span>
                                        @elseif($data->status_terakhir == 'ReqHapus')
                                        <span class="badge badge-warning">Request <i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                        @elseif($data->status_terakhir == 'reqAddTime')
                                        <span class="badge badge-warning">Request <i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                        @elseif($data->status_terakhir == 'Selesai')
                                        <span class="badge badge-success">Closed</span>
                                        @elseif($data->status_terakhir == 'Manager')
                                        <span class="badge badge-success">Manager</span>
                                        @elseif($data->status_terakhir == 'Dibatalkan')
                                        <span class="badge badge-danger">Cancel</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{url('detail-laporan-admin',$data->id)}}"><button class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></button></a>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#basicModal{{$data->id}}"><i class="fa fa-history"></i></button>
                                        <!-- <a data-toggle="modal" data-target="#exampleModalDetail{{$data->id}}" data-whatever="@getbootstrap"><button class="btn btn-primary btn-sm"><i class="fa fa-history"></i></button></a> -->
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        @foreach($dtLap as $dt)
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
                                                    @elseif($dthist->status_laporan == 'Diproses')
                                                    <span class="badge badge-info">Process</span>
                                                    @elseif($dthist->status_laporan == 'Selesai')
                                                    <span class="badge badge-success">Closed</span>
                                                    @elseif($dthist->status_laporan == 'Dibatalkan')
                                                    <span class="badge badge-danger">Cancel</span>
                                                    @elseif($dthist->status_laporan == 'ReqHapus')
                                                    <span class="badge badge-warning">Request <i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                                    @elseif($dthist->status_laporan == 'CheckedU')
                                                    <span class="badge badge-warning">User Checking</span>
                                                    @elseif($dthist->status_laporan == 'reqAddTime')
                                                    <span class="badge badge-info">Process</span>
                                                    @elseif($dthist->status_laporan == 'Manager')
                                                    <span class="badge badge-dark">Manager</span>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection