@extends('template')
@section('style')
<style>
    .table1 {
        border-collapse: collapse;
        border-spacing: 10px;
    }

    .table1 th,
    .table1 td {
        border: 1px solid black;
        padding: 2px;
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    @if(Session::has('success'))
    <div class="toastr-trigger" data-type="success" data-message="Kop Surat Diperbaruai" data-position-class="Berhasil!"></div>
    @endif

    <!-- <div class="toastr-trigger" data-type="error" data-message="Kop Surat Batal Diperbaruai" data-position-class="Dibatalkan!"></div> -->

    <div class="col-md-12">
        @if($kop->preview == 1)
        <div class="card">
            <div class="card-body">
                <form action="{{route('preview-kop-surat',$kop->id)}}" method="post">
                    {{csrf_field()}}
                    <div class="d-flex">
                        <div class="mr-auto p-2"><span class="label label-warning">Preview Kop Surat</span></div>
                        <div class="p-2"><button type="submit" class="btn btn-danger btn-sm" name="update" value="batal">Batal</button></div>
                        <div class="p-2"><button type="submit" class="btn btn-success btn-sm" name="update" value="kirim">Kirim</button>
                        </div>
                    </div>
                </form>
                <!-- <span class="badge badge-warning">Preview Kop Surat</span> <br><br> <button type="submit" class="btn btn-danger">Batal</button>
                <button type="submit" class="btn btn-success">Kirim</button> -->
                <table style="width: 100%; color: black; font-size: 15px;" class="table1">
                    <tr>
                        <td rowspan="4" style="width: 25%; margin-top: 5px;" valign="center" align="center">
                            <img src="{{asset('storage/img/kop_surat/kop_kai.png')}}" width="150" height="70" />
                            <!-- <i style="color: #3167D5; cursor: pointer;" valign="top" type="button" data-toggle="modal" data-target="#exampleModalP" data-whatever="@getbootstrap" class="fa fa-pencil-square-o"></i> -->
                        </td>
                        <td rowspan="2" valign="center">
                            PT Kereta Api Indonesia <br> Sistem Informasi
                        </td>
                        <td style="width: 10%;">Nomor</td>
                        <td style="width: 25%;">{{$kop->nomor}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>{{$tanggal_f}}</td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            BERITA ACARA INSTALASI DAN <br> TROUBLESHOOTING LAYANAN IT
                        </td>
                        <td>Versi</td>
                        <td>{{$kop->versi}}</td>
                    </tr>
                    <tr>
                        <td>Halaman</td>
                        <td>{{$kop->halaman}}</td>
                    </tr>
                </table> <br>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body">
                <!-- <h4 class="card-title">Setting Kop Surat Laporan</h4><br> -->
                <!-- <p style="color: black;">Preview</p> -->
                <!-- <span class="badge badge-warning">Preview Kop Surat</span> <br><br>
                <table style="width: 100%; color: black; font-size: 15px;" class="table1">
                    <tr>
                        <td rowspan="4" style="width: 25%; margin-top: 5px;" valign="center" align="center">
                            <img src="{{asset('storage/img/kop_surat/kop_kai.png')}}" width="150" height="70" />
                        </td>
                        <td rowspan="2" valign="center">
                            PT Kereta Api Indonesia <br> Sistem Informasi
                        </td>
                        <td style="width: 10%;">Nomor</td>
                        <td style="width: 25%;">{{$kop->nomor}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>{{$tanggal_f}}</td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            BERITA ACARA INSTALASI DAN <br> TROUBLESHOOTING LAYANAN IT
                        </td>
                        <td>Versi</td>
                        <td>{{$kop->versi}}</td>
                    </tr>
                    <tr>
                        <td>Halaman</td>
                        <td>{{$kop->halaman}}</td>
                    </tr>
                </table><br><br> -->
                <table style="width: 100%; color: black; font-size: 15px;" class="table1">
                    <tr>
                        <td rowspan="4" style="width: 25%; margin-top: 5px;" valign="center" align="center">
                            <img src="{{asset('storage/img/kop_surat/kop_kai.png')}}" width="150" height="70" />
                            <!-- <i style="color: #3167D5; cursor: pointer;" valign="top" type="button" data-toggle="modal" data-target="#exampleModalP" data-whatever="@getbootstrap" class="fa fa-pencil-square-o"></i> -->
                        </td>
                        <td rowspan="2" valign="center">
                            PT Kereta Api Indonesia <br> Sistem Informasi
                        </td>
                        <td style="width: 10%;">Nomor</td>
                        <td style="width: 25%;">{{$kop->nomor}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>{{$tanggal_f}}</td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            BERITA ACARA INSTALASI DAN <br> TROUBLESHOOTING LAYANAN IT
                        </td>
                        <td>Versi</td>
                        <td>{{$kop->versi}}</td>
                    </tr>
                    <tr>
                        <td>Halaman</td>
                        <td>{{$kop->halaman}}</td>
                    </tr>
                </table> <br>
                <div class="basic-form">
                    <form action="{{route('update-kop-surat',$kop->id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nomor" value="{{$kop->nomor}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tanggal" value="{{$kop->tanggal}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Versi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="versi" value="{{$kop->versi}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Halaman</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="halaman" value="{{$kop->halaman}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="keterangan" value="{{$kop->keterangan}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="accordion-three" class="accordion">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo5" aria-expanded="false" aria-controls="collapseTwo5"><i class="fa" aria-hidden="true"></i> History Kop Surat</h5>
                        </div>
                        <div id="collapseTwo5" class="collapse" data-parent="#accordion-three">
                            <div class="card-body">
                                <table style="width: 100%; color: black; font-size: 12px;" class="table1">
                                    <tr>
                                        <td colspan="2" align="center">Tanggal Sistem</td>
                                        <td colspan="2" align="center">Nomor</td>
                                        <td colspan="2" align="center">Tanggal Surat</td>
                                        <td colspan="2" align="center">Versi</td>
                                        <td colspan="2" align="center">Halaman</td>
                                        <td rowspan="2" align="center" style="width: 10%;">Keterangan</td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="width: 9%;">Kini</td>
                                        <td align="center" style="width: 9%;">Lampau</td>
                                        <td align="center" style="width: 11%;">Kini</td>
                                        <td align="center" style="width: 11%;">Lampau</td>
                                        <td align="center" style="width: 9%;">Kini</td>
                                        <td align="center" style="width: 9%;">Lampau</td>
                                        <td align="center" style="width: 9%;">Kini</td>
                                        <td align="center" style="width: 9%;">Lampau</td>
                                        <td align="center" style="width: 7%;">Kini</td>
                                        <td align="center" style="width: 7%;">Lampau</td>
                                    </tr>
                                    <tr>
                                        <td align="center">{{ $kopSurat[0]->created_at }}</td>
                                        <td align="center">{{ $kopSurat[1]->created_at }}</td>
                                        <td align="center">{{ $kopSurat[0]->nomor }}</td>
                                        <td align="center">{{ $kopSurat[1]->nomor }}</td>
                                        <td align="center">{{ $kopSurat[0]->tanggal }}</td>
                                        <td align="center">{{ $kopSurat[1]->tanggal }}</td>
                                        <td align="center">{{ $kopSurat[0]->versi }}</td>
                                        <td align="center">{{ $kopSurat[1]->versi }}</td>
                                        <td align="center">{{ $kopSurat[0]->halaman }}</td>
                                        <td align="center">{{ $kopSurat[1]->halaman }}</td>
                                        <td align="center">{{ $kopSurat[0]->keterangan }}</td>
                                    </tr>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection