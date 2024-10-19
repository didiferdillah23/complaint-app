<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>IT KAI DAOP 4 SEMARANG</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="5x5" width href="{{asset('storage/img/logo kai atas.png')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="{{asset('quixlab/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('quixlab/plugins/toastr/css/toastr.min.css')}}" rel="stylesheet">
</head>

<body class="h-100">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <div class="text-center" href="index.html">
                                    <!-- <img class="text-center" src="{{asset('storage/img/kai.png')}}" width="140" height="60" /> -->
                                    <h3>PENDAFTARAN PENGAWAS</h3>
                                </div>
                                @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <div class="toastr-trigger" data-type="error" data-message="{{ $error }}" data-position-class="Email Sudah Terdaftar Sebelumnya!"></div>
                                @endforeach
                                @endif

                                <form class="mt-8 mb-8 login-input" action="{{route('regist-pengawas')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input type="text" required class="form-control input-flat" value="{{ old('nama') }}" name="nama" placeholder="Nama" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" required class="form-control input-flat" value="{{ old('nipp') }}" name="nipp" placeholder="NIPP" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" required class="form-control" value="{{ old('jabatan') }}" name="jabatan" placeholder="Jabatan" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" required class="form-control" value="{{ old('email') }}" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" required class="form-control" value="{{ old('password') }}" name="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Upload Gambar Tanda Tangan</label>
                                        <input type="file" class="form-control" value="{{ old('ttd') }}" name="ttd" placeholder="Upload TTD" required>
                                    </div>
                                    <button class="btn login-form__btn submit w-100">Daftar</button>
                                </form>
                                <p class="mt-5 login-form__footer">Sudah punya akun? <a href="{{url('')}}" class="text-primary">Masuk </a> sekarang</p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{asset('quixlab/plugins/common/common.min.js')}}"></script>
    <script src="{{asset('quixlab/js/custom.min.js')}}"></script>
    <script src="{{asset('quixlab/js/settings.js')}}"></script>
    <script src="{{asset('quixlab/js/gleek.js')}}"></script>
    <script src="{{asset('quixlab/js/styleSwitcher.js')}}"></script>
    <script src="{{asset('quixlab/plugins/toastr/js/toastr.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/toastr/js/toastr.init.js')}}"></script>
</body>

</html>