@extends('template')

@section('content')
@if(Session::has('success'))
<div class="toastr-trigger" data-type="success" data-message="Laporan Dialihkan" data-position-class="Berhasil"></div>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex bd-highlight mb-3">
                        <div class="mr-auto p-2 bd-highlight">
                            <h3>Data Permintaan Layanan</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table style="color: #2D3134;" class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Pelapor</th>
                                    <th>No Referensi</th>
                                    <th>No Inventaris</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Teknisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach ($lap as $data)
                                <?php $no++ ?>
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $data->tgl_masuk }}</td>
                                    <td>{{ $data->nama_pelapor }}</td>
                                    <td>{{ $data->lap_no_ref }}</td>
                                    <td>{{ $data->no_inv_aset }}</td>
                                    <td>{{ $data->tgl_selesai }}</td>
                                    <td>
                                        @if($data->id_teknisi != null)
                                        {{$data->nama_teknisi}}
                                        @else
                                        <i>Teknisi belum dipilih</i>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('detail-laporan',$data->id)}}"><button class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></button></a>
                                        <a href="{{url('ambil-laporan',$data->id)}}"><button class="btn btn-primary btn-sm"><i class="fa fa-hand-paper-o"></i></button></a>

                                        <!-- @if($data->ttd != null)
                                        <a href="{{url('cetak-laporan',$data->id)}}"><button class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o"></i></button></a>
                                        @else
                                        <a href="{{url('profile-pengawas')}}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Masukkan TTD dahulu"><i class="fa fa-file-pdf-o"></i></button></a>
                                        @endif -->
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        <!-- ========= MODAL ========= -->

                        <!-- ========= END MODAL ========= -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection