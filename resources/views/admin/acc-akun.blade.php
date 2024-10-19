@extends('template')
@section('content')
<div class="container-fluid">
    @if(Session::has('success'))
    <div class="toastr-trigger" data-type="success" data-message="Akun Sudah Disetujui" data-position-class="Berhasil!"></div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Persetujuan Akun Pengguna</h4>
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item"><a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Pelapor</a></li>
                    <li class="nav-item"><a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Teknisi IT</a></li>
                    <li class="nav-item"><a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="false">Pengawas</a></li>
                </ul>
                <div class="tab-content br-n pn">

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
                                                <th>Unit</th>
                                                <th>Email</th>
                                                <th>No Hp</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            @foreach($pelapor as $dtpelapor)
                                            <?php $no++ ?>
                                            <tr>
                                                <td>{{$no}}</td>
                                                <td>{{$dtpelapor->nama}}</td>
                                                <td>{{$dtpelapor->nipp}}</td>
                                                <td>{{$dtpelapor->jabatan}}</td>
                                                <td>{{$dtpelapor->divisi}}</td>
                                                <td>{{$dtpelapor->email}}</td>
                                                <td>{{$dtpelapor->telepon}}</td>
                                                <td>
                                                    <form action="{{route('acc-akun',$dtpelapor->id)}}" method="post">
                                                        {{csrf_field()}}
                                                        <button type="submit" name="action" value="pelapor" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="Setujui"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== HALAMAN TAB AKUN TEKNISI ===== -->
                    <div id="navpills-2" class="tab-pane">
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
                                            @foreach($teknisi as $dtteknisi)
                                            <?php $no++ ?>
                                            <tr>
                                                <td>{{$no}}</td>
                                                <td>{{$dtteknisi->nama}}</td>
                                                <td>{{$dtteknisi->nipp}}</td>
                                                <td>{{$dtteknisi->jabatan}}</td>
                                                <td>{{$dtteknisi->email}}</td>
                                                <td>
                                                    <form action="{{route('acc-akun',$dtteknisi->id)}}" method="post">
                                                        {{csrf_field()}}
                                                        <button type="submit" name="action" value="teknisi" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="Setujui"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
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
                                            @foreach($pengawas as $dtpengawas)
                                            <?php $no++ ?>
                                            <tr>
                                                <td>{{$no}}</td>
                                                <td>{{$dtpengawas->nama}}</td>
                                                <td>{{$dtpengawas->nipp}}</td>
                                                <td>{{$dtpengawas->jabatan}}</td>
                                                <td>{{$dtpengawas->email}}</td>
                                                <td>
                                                    <form action="{{route('acc-akun',$dtpengawas->id)}}" method="post">
                                                        {{csrf_field()}}
                                                        <button type="submit" name="action" value="pengawas" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="Setujui"><i class="fa fa-check"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
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