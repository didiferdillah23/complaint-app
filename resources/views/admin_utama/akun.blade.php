@extends('template')
@section('content')
<div class="container-fluid">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                @if(Session::has('success'))
                <div class="toastr-trigger" data-type="success" data-message="Akun Sudah Dibuat" data-position-class="{{ Session::get('success') }}"></div>
                @elseif(Session::has('error'))
                <div class="toastr-trigger" data-type="error" data-message="Error" data-position-class="{{ Session::get('error') }}"></div>
                @elseif(Session::has('warning'))
                <div class="toastr-trigger" data-type="warning" data-message="Silahkan Hubungi Admin" data-position-class="{{ Session::get('warning') }}"></div>
                @endif

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
                                            @auth('admin_utama')
                                            <th>Kode Aktivasi</th>
                                            @endauth
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $i => $user)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->nipp }}</td>
                                            <td>{{ $user->jabatan }}</td>
                                            <td>{{ $user->email }}</td>
                                            @auth('admin_utama')
                                            <td>{{ $user->logAktivasi?->kode_aktivasi??'-' }}</td>
                                            @endauth
                                            <td>
                                            @auth('admin_utama')
                                                @if($user->logAktivasi?->kode_aktivasi == NULL)
                                                    <a href="/aktivasi-akun/{{ $user->id }}" onclick="return confirm('Apakah Yakin Mengaktivasi Akun Ini?')" class="btn btn-primary">Aktivasi</a>
                                                @endif
                                            @endauth

                                            @auth('admin')
                                            @if($user->kode_aktivasi == NULL)
                                                @if($user->logAktivasi?->kode_aktivasi != NULL)
                                                    <form action="/aktivasi-akun/{{ $user->id }}" method="post">
                                                        @csrf
                                                        <div class="d-flex">
                                                            <input type="text" name="code" id="code" required placeholder="Masukkan Kode" style="height: 20px;" class="form-control">
                                                            <button type="submit" class="btn btn-primary">Input Code</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            @endif
                                            @endauth

                                            @if($user->kode_aktivasi != NULL)
                                                <p class="text-success">&check; Sudah Aktif</p>
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