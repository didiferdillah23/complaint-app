@extends('template')
@section('content')
<div class="container-fluid">
    @if(Session::has('success'))
    <div class="toastr-trigger" data-type="success" data-message="Data berhasil diubah" data-position-class="Perubahan disimpan!"></div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pengguna</h4>
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item"><a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Pelapor</a></li>
                    <li class="nav-item"><a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Teknisi IT </a></li>
                    <li class="nav-item"><a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="false">Pengawas </a></li>
                </ul>
                <div class="tab-content br-n pn">
                    <!-- ===== HALAMAN TAB AKUN PELAPOR ===== -->
                    <div id="navpills-1" class="tab-pane active">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table style="color: #2D3134;" class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIPP</th>
                                                <th>Jabatan</th>
                                                <th>Divisi</th>
                                                <th>Email</th>
                                                <th>Telepon</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            @foreach($pelapor as $dtp)
                                            <?php $no++ ?>
                                            <tr>
                                                <td>{{$no}}</td>
                                                <td>{{$dtp->nama}}</td>
                                                <td>{{$dtp->nipp}}</td>
                                                <td>{{$dtp->jabatan}}</td>
                                                <td>{{$dtp->divisi}}</td>
                                                <td>{{$dtp->email}}</td>
                                                <td>{{$dtp->telepon}}</td>
                                                <td>
                                                    <!-- <a href="{{url('edit-pelapor',$dtp->id)}}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></button></a> -->
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{$dtp->id}}" data-whatever="@getbootstrap"><i class="fa fa-pencil"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @foreach($pelapor as $dtp2)
                                    <div class="modal fade" id="exampleModal{{$dtp2->id}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{route('edit-pelapor-save',$dtp2->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Data Pelapor</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Nama</label>
                                                                <input type="text" class="form-control" name="nama" placeholder="Nama Pelapor" value="{{$dtp2->nama}}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>NIPP</label>
                                                                <input type="text" class="form-control" name="nipp" placeholder="NIPP" value="{{$dtp2->nipp}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Jabatan</label>
                                                                <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="{{$dtp2->jabatan}}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Divisi</label>
                                                                <input type="text" class="form-control" name="divisi" placeholder="Divisi" value="{{$dtp2->divisi}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Email</label>
                                                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{$dtp2->email}}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Nomor HP</label>
                                                                <input type="text" class="form-control" name="telepon" placeholder="No HP" value="{{$dtp2->telepon}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label style="color: red;">Password</label>
                                                            <input type="text" class="form-control" name="new_password" placeholder="Reset Password Pelapor">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ===== END HALAMAN TAB AKUN PELAPOR ===== -->

                    <!-- ===== HALAMAN TAB AKUN TEKNISI ===== -->
                    <div id="navpills-2" class="tab-pane">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table style="color: #2D3134; width: 100%;" class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th style="width: 40%;">Nama</th>
                                                <th>NIPP</th>
                                                <th>Jabatan</th>
                                                <th>Email</th>
                                                <th>Trouble</th>
                                                <th>Instalasi</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            @foreach($it as $dtit)
                                            <?php $no++ ?>
                                            <tr>
                                                <td>{{$no}}</td>
                                                <td>{{$dtit->nama}}</td>
                                                <td>{{$dtit->nipp}}</td>
                                                <td>{{$dtit->jabatan}}</td>
                                                <td>{{$dtit->email}}</td>
                                                <td>{{$dtit->total_troubleshooting}}</td>
                                                <td>{{$dtit->total_instalasi}}</td>
                                                <td>{{$dtit->jumlah_laporan}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalIT{{$dtit->id}}" data-whatever="@getbootstrap"><i class="fa fa-pencil"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @foreach($it as $dtit2)
                                    <div class="modal fade" id="exampleModalIT{{$dtit2->id}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{route('edit-teknisi-save',$dtit2->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Data Teknisi IT</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Nama</label>
                                                                <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{$dtit2->nama}}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>NIPP</label>
                                                                <input type="text" class="form-control" name="nipp" placeholder="NIPP" value="{{$dtit2->nipp}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Jabatan</label>
                                                                <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="{{$dtit2->jabatan}}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Email</label>
                                                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{$dtit2->email}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ===== END HALAMAN TAB AKUN TEKNISI ===== -->

                    <!-- ===== HALAMAN TAB AKUN PENGAWAS ===== -->
                    <div id="navpills-3" class="tab-pane">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table style="color: #2D3134;" class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIPP</th>
                                                <th>Jabatan</th>
                                                <th>Email</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            @foreach($pws as $dtpws)
                                            <?php $no++ ?>
                                            <tr>
                                                <td>{{$no}}</td>
                                                <td>{{$dtpws->nama}}</td>
                                                <td>{{$dtpws->nipp}}</td>
                                                <td>{{$dtpws->jabatan}}</td>
                                                <td>{{$dtpws->email}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalPws{{$dtpws->id}}" data-whatever="@getbootstrap"><i class="fa fa-pencil"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @foreach($pws as $dtpws2)
                                    <div class="modal fade" id="exampleModalPws{{$dtpws2->id}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{route('edit-pengawas-save',$dtpws2->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    <div class="modal-header">
                                                        <h5 class="modal-tpwsle">Edpws Data Teknisi pws</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Nama</label>
                                                                <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{$dtpws2->nama}}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>NIPP</label>
                                                                <input type="text" class="form-control" name="nipp" placeholder="NIPP" value="{{$dtpws2->nipp}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Jabatan</label>
                                                                <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="{{$dtpws2->jabatan}}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Email</label>
                                                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{$dtpws2->email}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ===== END HALAMAN TAB AKUN PENGAWAS ===== -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection