@extends('template')
@section('content')
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-5">
                        <b style="color: #2D3134;">Profile Pelapor</b><br>
                        <form action="{{route('save-foto-pelapor',$dt->id)}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}

                            @if($dt->profile == null)
                            <p>Foto belum ada</p>
                            @else
                            <img src="{{asset('storage/img/pp_pelapor/'. $dt->profile)}}" style="border: 1px #2D3134 solid;" width="150px" height="150px">
                            <input type="hidden" name="profile_old" value="{{$dt->profile}}">
                            @endif
                            <div class="form-group">
                                <input type="file" name="profile">
                            </div>
                            <button type="submit" class="btn btn-primary m-t-20">Submit</button>
                        </form>
                    </div>
                    <div class="col-7">
                        <table style="color: #2D3134;">
                            <tr>
                                <td style="width: 150px; height: 30px;">Nama</td>
                                <td style="width: 15px;">:</td>
                                <td>{{$dt->nama}}</td>
                            </tr>
                            <tr>
                                <td style="width: 150px; height: 30px;">NIPP</td>
                                <td style="width: 15px;">:</td>
                                <td>{{$dt->nipp}}</td>
                            </tr>
                            <tr>
                                <td style="width: 150px; height: 30px;">Jabatan</td>
                                <td style="width: 15px;">:</td>
                                <td>{{$dt->jabatan}}</td>
                            </tr>
                            <tr>
                                <td style="width: 150px; height: 30px;">Unit</td>
                                <td style="width: 15px;">:</td>
                                <td>{{$dt->divisi}}</td>
                            </tr>
                            <tr>
                                <td style="width: 150px; height: 30px;">Telepon</td>
                                <td style="width: 15px;">:</td>
                                <td>{{$dt->telepon}}</td>
                            </tr>
                            <tr>
                                <td style="width: 150px; height: 30px;">Email</td>
                                <td style="width: 15px;">:</td>
                                <td>{{$dt->email}}</td>
                            </tr>
                            <tr>
                                <td style="width: 150px; height: 30px;">Tanda Tangan</td>
                                <td style="width: 15px;">:</td>
                                <td><a href="" style="color: #2D3134;" data-toggle="modal" data-target="#basicModal"><u>pratinjau gambar</u></a></td>
                            </tr>
                        </table>
                        <div class="modal fade" id="basicModal">
                            <div class="modal-dialog" role="document">
                                <form action="{{route('save-ttd-pelapor',$dt->id)}}" method="POST" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tanda Tangan</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{csrf_field()}}
                                            @if($dt->ttd == null)
                                            <i>Tanda Tangan belum di upload</i>
                                            @else
                                            <img src="{{asset('storage/img/pelapor/'. $dt->ttd)}}" style="border: 1px #2D3134 solid;" width="200px" height="200px">
                                            <input type="hidden" name="ttd_old" value="{{$dt->ttd}}">
                                            @endif
                                            <div class="form-group">
                                                <input type="file" name="ttd">
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
                        <!-- <b>Tanda Tangan</b><br>
                        <table style="width: 100%;">
                            <form action="{{route('save-ttd-pelapor',$dt->id)}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <tr>
                                    <td style="width: 50%; padding: 5px;">
                                        @if($dt->ttd == null)
                                        <i>Tanda Tangan belum di upload</i>
                                        @else
                                        <img src="{{asset('storage/img/pelapor/'. $dt->ttd)}}" style="border: 1px #2D3134 solid;" width="150px" height="150px">
                                        <input type="hidden" name="ttd_old" value="{{$dt->ttd}}">
                                        @endif
                                        <p style="color: red; font-size: 11px;">*Pastikan gambar tanda tangan sudah tidak memiliki background</p>
                                    </td>
                                    <td valign="top" style="width: 50%; padding: 3px;">
                                        <div class="basic-form">
                                            <div class="form-group">
                                                <input type="file" name="ttd">
                                            </div>
                                            <button type="submit" class="btn btn-primary m-t-20">Submit</button>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                        </table> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection