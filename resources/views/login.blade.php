<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>IT KAI DAOP 4 SEMARANG</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="5x5" width href="{{asset('storage/img/logo kai atas.png')}}">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
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
                        <!-- fdgdfgdfggdf <br> fdgdfgdfggdf <br>fdgdfgdfggdf <br>fdgdfgdfggdf <br> -->
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <div class="text-center">
                                    <img class="text-center" src="{{asset('storage/img/kai.png')}}" width="140" height="60" />
                                    <h3>DAOP 4 Kota Semarang <br> PT. Kereta Api Indonesia</h3>
                                    <h6>Sistem Informasi Pelayanan</h6>
                                    </a>
                                    
                                    @if(Session::has('success'))
                                    <div class="toastr-trigger" data-type="success" data-message="Akun Sudah Dibuat" data-position-class="{{ Session::get('success') }}"></div>
                                    @elseif(Session::has('error'))
                                    <div class="toastr-trigger" data-type="error" data-message="Error" data-position-class="{{ Session::get('error') }}"></div>
                                    @elseif(Session::has('warning'))
                                    <div class="toastr-trigger" data-type="warning" data-message="Silahkan Hubungi Admin" data-position-class="{{ Session::get('warning') }}"></div>
                                    @endif

                                    <form action="{{route('postlogin')}}" method="post" class="mt-5 mb-5 login-input">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <input type="email" name="email" required class="form-control" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" required class="form-control" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn login-form__btn submit w-100">Masuk</button>
                                    </form>
                                    <p class="mt-5 login-form__footer">Belum punya akun? <a href="{{url('register')}}" class="text-primary">Daftar</a> sekarang</p>
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
