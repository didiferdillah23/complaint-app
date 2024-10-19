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
                    <div class="d-flex bd-highlight mb-3">
                        <div class="mr-auto p-2 bd-highlight">
                            <h3>Pengaturan Broadcast</h3>
                        </div>
                        <div class="p-2 bd-highlight">
                            <a href="{{url('add-broadcast')}}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Broadcast</button></a>
                        </div>
                    </div>
                    <!-- <h4 class="card-title">Pengaturan Broadcast</h4> -->

                    <div class="table-responsive">
                        <table style="color: #2D3134;" class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Infromasi</th>
                                    <th>Tanggal Diupload</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach ($bc as $dt)
                                <?php $no++ ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{$dt->judul}}</td>
                                    <td>{{$dt->informasi}}</td>
                                    <td>{{$dt->tgl_tampil}}</td>
                                    <td>{{$dt->tgl_selesai}}</td>
                                    <td></td>
                                    <td>
                                        <a href="{{url('edit-broadcast',$dt->id)}}"><button class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button></a>
                                        <a href="{{url('edit-comp',$dt->id)}}"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection