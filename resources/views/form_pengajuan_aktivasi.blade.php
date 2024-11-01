@extends('template')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        
                        @if(Session::has('success'))
                        <div class="toastr-trigger" data-type="success" data-message="" data-position-class="{{ Session::get('success') }}"></div>
                        @elseif(Session::has('error'))
                        <div class="toastr-trigger" data-type="error" data-message="" data-position-class="{{ Session::get('error') }}"></div>
                        @elseif(Session::has('warning'))
                        <div class="toastr-trigger" data-type="warning" data-message="" data-position-class="{{ Session::get('warning') }}"></div>
                        @endif

                        <h4><i class="icon-lock"></i> Pengajuan Aktivasi</h4>
                        <p class="text-muted mb-4">
                            Akun Anda akan diaktivasi setelah persetujuan admin operasional. Admin akan mengirimkan kode aktivasi setelah pengajuan disetujui.
                        </p>

                        @if($aktivasi == NULL)
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $user->nama }}</td>
                                </tr>
                                <tr>
                                    <th>NIPP</th>
                                    <td>{{ $user->nipp }}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>{{ $user->jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Tgl Habis Trial</th>
                                    <td>{{ $user->limit_trial }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <form action="/submit-aktivasi" onsubmit="return confirm('Ajukan aktivasi?')" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Ajukan Aktivasi</button>
                        </form>
                        @endif

                        @if($aktivasi?->persetujuan_pengawas == 'pengajuan')
                        <div class="alert alert-warning" role="alert">
                            Akun ini sedang diproses. Admin akan mengirimkan kode aktivasi setelah pengajuan disetujui.
                        </div>
                        @endif
                        
                        @if($aktivasi?->persetujuan_pengawas == 'disetujui' && $user->kode_aktivasi == NULL)
                        <form action="/submit-kode-aktivasi" onsubmit="return confirm('Inputkan kode aktivasi?')" method="POST">
                            @csrf
                            <input type="text" class="form-control mb-3" name="kode_aktivasi" required placeholder="Kode aktivasi">
                            <button type="submit" class="btn btn-primary w-100">Aktivasi</button>
                        </form>
                        @endif

                        @if($aktivasi?->persetujuan_pengawas == 'disetujui' && $user->kode_aktivasi != NULL)
                        <div class="alert alert-success" role="alert">
                            Selamat, Akun ini sudah diaktivasi. Sekarang anda dapat menggunakan fitur yang awalnya terkunci.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
