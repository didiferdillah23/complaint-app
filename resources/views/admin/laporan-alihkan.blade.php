@extends('template')

@section('content')
@if(Session::has('success'))
<div class="toastr-trigger" data-type="success" data-message="{{ Session::get('success') }}" data-position-class="Berhasil"></div>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pengajuan Peralihan Penanggung Jawab Laporan</h4>
                    <div class="table-responsive">
                        <table style="color: #2D3134;" class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Nama Pelapor</th>
                                    <th>No Inventaris</th>
                                    <th>Teknisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach ($dtLap as $data)
                                <?php $no++ ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{ $data->tgl_masuk_f }}</td>
                                    <td>{{ $data->nama_pelapor }}</td>
                                    <td>{{ $data->no_inv_aset }}</td>
                                    <td>
                                        @if($data->id_teknisi != null)
                                        {{$data->nama_teknisi}}
                                        @else
                                        <i><b>Belum di proses</b></i>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('detail-laporan-admin',$data->id)}}"><button class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></button></a>
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalPeralihan{{$data->id}}" data-whatever="@getbootstrap"><i class="fa fa-check"></i></button>
                                        <!-- @if($data->id_teknisi == null)
                                        <a data-toggle="modal" data-target="#exampleModalDetail{{$data->id}}" data-whatever="@getbootstrap"><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i></button></a>
                                        @else
                                        <a data-toggle="modal" data-target="#exampleModalDetail{{$data->id}}" data-whatever="@getbootstrap"><button disabled class="btn btn-primary btn-sm"><i class="fa fa-bars"></i></button></a>
                                        @endif -->
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        @foreach ($dtLap as $detail)
                        <div class="modal fade" id="exampleModalDetail{{$detail->id}}">
                            <div class="modal-dialog" role="document">
                                <form action="{{route('pilih-teknisi',$detail->id)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Proses Laporan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <select name="id_teknisi" class="form-control">
                                                <option value="" selected disabled>Pilih Teknisi</option>
                                                @foreach ($teknisi as $dtt)
                                                <option value="{{$dtt->id}}">{{$dtt->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Kirim</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach

                        <!-- MODAL PERSETUJUAN PERALIHAN -->
                        @foreach ($dtLap as $dt)
                        <div class="modal fade" id="exampleModalPeralihan{{$dt->id}}">
                            <div class="modal-dialog" role="document">
                                <form action="{{route('acc-laporan-alihkan',$dt->id)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Persetujuan Peralihan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table style="color: #2D3134;">
                                                <tr style="height: 25px;" valign="top">
                                                    <td colspan="3"><b>Penanggung Jawab Pertama</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 90px;">Nama</td>
                                                    <td style="width: 20px;">:</td>
                                                    <td>{{$dt->nama_pengawas_id}}</td>
                                                </tr>
                                                <tr>
                                                    <td>NIPP</td>
                                                    <td>:</td>
                                                    <td>{{$dt->nipp_pengawas_id}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Jabatan</td>
                                                    <td>:</td>
                                                    <td>{{$dt->jabatan_pengawas_id}}</td>
                                                </tr>
                                                <tr style="height: 50px;" valign="top">
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td>{{$dt->email_pengawas_id}}</td>
                                                </tr>
                                                <tr style="height: 25px;" valign="top">
                                                    <td colspan="3"><b>Dilihkan ke</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 90px;">Nama</td>
                                                    <td style="width: 20px;">:</td>
                                                    <td>{{$dt->nama_pengawas_alihkan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>NIPP</td>
                                                    <td>:</td>
                                                    <td>{{$dt->nipp_pengawas_alihkan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Jabatan</td>
                                                    <td>:</td>
                                                    <td>{{$dt->jabatan_pengawas_alihkan}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td>{{$dt->email_pengawas_alihkan}}</td>
                                                </tr>
                                                <input type="text" name="alihkan_pws" value="{{$dt->alihkan_pws}}" hidden>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger" name="alihkan" value="tolak">Tolak</button>
                                            <button type="submit" class="btn btn-success" name="alihkan" value="setuju">Setujui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        <!-- END MODAL PERSETUJUAN PERALIHAN -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection