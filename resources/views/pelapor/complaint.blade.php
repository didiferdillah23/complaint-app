@extends('template')

@section('content')
<div class="container-fluid">
    @if(Session::has('batal'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button> <strong>Info !</strong> {{ Session::get('batal') }}
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex bd-highlight mb-3">
                        <div class="mr-auto p-2 bd-highlight">
                            <h3>Data Permintaan Layanan</h3>
                        </div>
                        <div class="p-2 bd-highlight">
                            <a href="{{url('form-comp')}}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Permintaan</button></a>
                            <!-- <a href=""><button type="button" class="btn mb-1 btn-primary">Permintaan <span class="btn-icon-right"><i class="fa fa-plus"></i></span></a> -->
                            <!-- <button onclick="window.location={{url('/form-comp')}}" type="button" class="btn mb-1 btn-primary">Permintaan <span class="btn-icon-right"><i class="fa fa-plus"></i></span> -->
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table style="color: #2D3134;" class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Permintaan</th>
                                    <th>No Inventaris</th>
                                    <th>Batas Akhir Pengerjaan</th>
                                    <th>Waktu Tambahan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach ($dtLap as $data)
                                <?php $no++ ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{ $data->tgl_masuk }}</td>
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
                                        @if($data->waktu_tambahan != null)
                                        {{ $data->waktu_tambahan }} hari
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->status_terakhir == 'Pengajuan')
                                        <span class="badge badge-primary">Open</span>
                                        @elseif($data->status_terakhir == 'Diproses')
                                        <span class="badge badge-info">Diproses</span>
                                        @elseif($data->status_terakhir == 'CheckedU' or $data->status_terakhir == 'CheckLapU' or $data->status_terakhir == 'reqAddTime')
                                        <span class="badge badge-warning">Postponed</span>
                                        @elseif($data->status_terakhir == 'ReqHapus')
                                        <span class="badge badge-warning">Request <i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{url('detail-comp',$data->id)}}"><button class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></button></a>
                                        @if($data->status_terakhir == 'Pengajuan')
                                        <a href="{{url('edit-comp',$data->id)}}"><button class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button></a>
                                        @else
                                        <a href="{{url('edit-comp',$data->id)}}"><button disabled class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button></a>
                                        @endif
                                        <!-- <a href="{{url('delete-laporan',$data->id)}}" onclick="return confirm('Apakah Yakin Hapus Data Ini?')" style="color: #C63F56;"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a> -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal{{$data->id}}" data-whatever="@getbootstrap"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        @foreach($dtLap as $dt)
                        <!-- ========= MODAL ALASAN PEMBATALAN ========= -->
                        <div class="modal fade" id="exampleModal{{$dt->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="{{url('delete-laporan',$dt->id)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Alasan Pembatalan Laporan:</label>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection