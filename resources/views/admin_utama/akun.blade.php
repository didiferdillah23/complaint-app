@extends('template')
@section('content')
<div class="container-fluid">
    @if(Session::has('success'))
    <div class="toastr-trigger" data-type="success" data-message="Data berhasil diubah" data-position-class="Perubahan disimpan!"></div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pemohon Aktivasi</h4>
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item"><a href="?active_tab=teknisi" class="nav-link @if($active_tab == 'teknisi') active @endif">Teknisi IT </a></li>
                </ul>
                <div class="tab-content br-n pn">
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
                                        @foreach($users as $i => $user)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $user->relatable->nama }}</td>
                                            <td>{{ $user->relatable->nipp }}</td>
                                            <td>{{ $user->relatable->jabatan }}</td>
                                            <td>{{ $user->relatable->email }}</td>
                                            <td>
                                                @if($user->persetujuan_pengawas == 'pengajuan' && Auth::guard('admin')->check())
                                                    <a href="/setujui-aktivasi/{{ $user->id }}" onclick="return confirm('Apakah Yakin Setujui Akun Ini?')" class="btn btn-primary">Setujui</a>
                                                @endif

                                                @if($user->persetujuan_pengawas == 'disetujui' && Auth::guard('admin_utama')->check() && $user->kode_aktivasi == NULL)
                                                    <a href="/aktivasi-akun/{{ $user->id }}" onclick="return confirm('Apakah Yakin Mengaktivasi Akun Ini?')" class="btn btn-primary">Aktivasi</a>
                                                @endif
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
    </div>
</div>
@endsection