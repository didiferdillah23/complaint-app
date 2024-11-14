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

                        @if($aktivasi == NULL)
                        <p class="text-muted mb-4">
                            Akun anda belum diaktivasi, silahkan hubungi developer untuk mengaktivasikan akun anda.
                        </p>
                        @endif

                        @if($user->kode_aktivasi != NULL)
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
