@extends('template')
@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:history.back()">Akun Pelapor</a></li>
            <li class="breadcrumb-item active"><a>Edit</a></li>
        </ol>
    </div>
</div>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h2 class="modal-title">Edit Data Pelapor</h2> <br><br>

                @foreach($pelapor as $dtp2)
                <div class="basic-form">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" placeholder="Nama Pelapor" value="{{$dtp2->nama}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NIPP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nipp" placeholder="NIPP" value="{{$dtp2->nipp}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="{{$dtp2->jabatan}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Divisi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="divisi" placeholder="Divisi" value="{{$dtp2->divisi}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor HP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="telepon" placeholder="No HP" value="{{$dtp2->telepon}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" placeholder="Email" value="{{$dtp2->email}}">
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-dark">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection