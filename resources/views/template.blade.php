<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>IT KAI DAOP 4 SEMARANG</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="5x5" width href="{{asset('storage/img/logo kai atas.png')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Pignose Calender -->
    <link href="{{asset('quixlab/plugins/pg-calendar/css/pignose.calendar.min.css')}}" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="{{asset('quixlab/plugins/chartist/css/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('quixlab/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css')}}">

    <link href="{{asset('quixlab/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link href="{{asset('quixlab/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="{{asset('quixlab/plugins/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="{{asset('quixlab/plugins/jquery-asColorPicker-master/css/asColorPicker.css')}}" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="{{asset('quixlab/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <!-- Daterange picker plugins css -->
    <link href="{{asset('quixlab/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('quixlab/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <link href="{{asset('quixlab/plugins/sweetalert/css/sweetalert.css')}}" rel="stylesheet">
    <link href="{{asset('quixlab/plugins/toastr/css/toastr.min.css')}}" rel="stylesheet">

    <!-- Pignose Calender -->
    <link href="{{asset('quixlab/plugins/pg-calendar/css/pignose.calendar.min.css')}}" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="{{asset('quixlab/plugins/chartist/css/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('quixlab/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css')}}">

    <!-- Custom Stylesheet -->
    <link href="{{asset('quixlab/css/style.css')}}" rel="stylesheet">
    @yield('style')
    @yield('script_atas')
</head>

<body>

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


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                @if (Str::length(Auth::guard('pelapor')->user()) > 0)
                <a href="/profile-pelapor')}}">
                    <b class="logo-abbr"><img src="{{asset('storage/img/kai-mini.png')}}" alt=""> </b>
                    <!-- <span class="logo-compact"><img src="{{asset('quixlab/images/logo-compact.png')}}" alt=""></span> -->
                    <span class="brand-title">
                        <img src="{{asset('storage/img/kai.png')}}" width="100" height="50" style="margin-left: 40px; margin-bottom: 10px;">
                    </span>
                    <!-- <h4 style="color: white;">Gambar Logo</h4> -->
                </a>
                @elseif (Str::length(Auth::guard('teknisi')->user()) > 0)
                <a href="{{url('profile-teknisi')}}">
                    <b class="logo-abbr"><img src="{{asset('storage/img/kai-mini.png')}}" alt=""> </b>
                    <!-- <span class="logo-compact"><img src="{{asset('quixlab/images/logo-compact.png')}}" alt=""></span> -->
                    <span class="brand-title">
                        <img src="{{asset('storage/img/kai.png')}}" width="100" height="50" style="margin-left: 40px; margin-bottom: 10px;">
                    </span>
                    <!-- <h4 style="color: white;">Gambar Logo</h4> -->
                </a>
                @elseif (Str::length(Auth::guard('admin')->user()) > 0)
                <a href="{{url('laporan-admin')}}">
                    <b class="logo-abbr"><img src="{{asset('storage/img/kai-mini.png')}}" alt=""> </b>
                    <!-- <span class="logo-compact"><img src="{{asset('quixlab/images/logo-compact.png')}}" alt=""></span> -->
                    <span class="brand-title">
                        <img src="{{asset('storage/img/kai.png')}}" width="100" height="50" style="margin-left: 40px; margin-bottom: 10px;">
                    </span>
                    <!-- <h4 style="color: white;">Gambar Logo</h4> -->
                </a>
                @elseif (Str::length(Auth::guard('pengawas')->user()) > 0)
                <a href="{{url('profile-pengawas')}}">
                    <b class="logo-abbr"><img src="{{asset('storage/img/kai-mini.png')}}" alt=""> </b>
                    <!-- <span class="logo-compact"><img src="{{asset('quixlab/images/logo-compact.png')}}" alt=""></span> -->
                    <span class="brand-title">
                        <img src="{{asset('storage/img/kai.png')}}" width="100" height="50" style="margin-left: 40px; margin-bottom: 10px;">
                    </span>
                    <!-- <h4 style="color: white;">Gambar Logo</h4> -->
                </a>
                @endif
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <!-- <div class="header-left">
                    <div class="input-group icons">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                        </div>
                        <input type="search" class="form-control" placeholder="Search Dashboard" aria-label="Search Dashboard">
                        <div class="drop-down animated flipInX d-md-none">
                            <form action="#">
                                <input type="text" class="form-control" placeholder="Search">
                            </form>
                        </div>
                    </div>
                </div> -->
                <div class="header-right">
                    <ul class="clearfix">
                        <!-- <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-email-outline"></i>
                                <span class="badge badge-pill gradient-1">3</span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">3 New Messages</span>
                                    <a href="javascript:void()" class="d-inline-block">
                                        <span class="badge badge-pill gradient-1">3</span>
                                    </a>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/1.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Saiful Islam</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/2.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Adam Smith</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Can you do me a favour?</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/3.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Barak Obama</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/4.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Hilari Clinton</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hello</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </li> -->
                        <!-- <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-pill gradient-2">3</span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">2 New Notifications</span>
                                    <a href="javascript:void()" class="d-inline-block">
                                        <span class="badge badge-pill gradient-2">5</span>
                                    </a>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events near you</h6>
                                                    <span class="notification-text">Within next 5 days</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Started</h6>
                                                    <span class="notification-text">One hour ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Ended Successfully</h6>
                                                    <span class="notification-text">One hour ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events to Join</h6>
                                                    <span class="notification-text">After two days</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </li> -->
                        <li class="icons dropdown d-md-flex">
                            @if (Str::length(Auth::guard('pelapor')->user()) > 0)
                            {{Auth::guard('pelapor')->user()->nama}} - Pelapor
                            @elseif (Str::length(Auth::guard('pengawas')->user()) > 0)
                            {{Auth::guard('pengawas')->user()->nama}} - Pengawas
                            @elseif (Str::length(Auth::guard('teknisi')->user()) > 0)
                            {{Auth::guard('teknisi')->user()->nama}} - Teknisi
                            @elseif (Str::length(Auth::guard('admin')->user()) > 0)
                            {{Auth::guard('admin')->user()->nama}}
                            @endif
                        </li>
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                @if (Str::length(Auth::guard('pelapor')->user()) > 0)
                                <img src="{{asset('storage/img/pp_pelapor/'. Auth::guard('pelapor')->user()->profile )}}" height="40" width="40" alt="">
                                @elseif (Str::length(Auth::guard('pengawas')->user()) > 0)
                                <img src="{{asset('quixlab/images/user/1.png')}}" height="40" width="40" alt="">
                                @elseif (Str::length(Auth::guard('teknisi')->user()) > 0)
                                <img src="{{asset('quixlab/images/user/1.png')}}" height="40" width="40" alt="">
                                @elseif (Str::length(Auth::guard('admin')->user()) > 0)
                                <img src="{{asset('quixlab/images/user/1.png')}}" height="40" width="40" alt="">
                                @endif
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            @if (Str::length(Auth::guard('pelapor')->user()) > 0)
                                            <a href="{{url('profile-pelapor')}}"><i class="icon-user"></i> <span>Profile</span></a>
                                            @elseif (Str::length(Auth::guard('pengawas')->user()) > 0)
                                            <a href="{{url('profile-pengawas')}}"><i class="icon-user"></i> <span>Profile</span></a>
                                            @elseif (Str::length(Auth::guard('teknisi')->user()) > 0)
                                            <a href="{{url('profile-teknisi')}}"><i class="icon-user"></i> <span>Profile</span></a>
                                            @endif
                                        </li>
                                        @if (Str::length(Auth::guard('pelapor')->user()) > 0)
                                        <li>
                                            <a href="{{url('password')}}"><i class="icon-lock"></i> <span>Ubah Password</span></a>
                                        </li>
                                        @endif
                                        <!-- <li><a href="page-login.html"><i class="icon-key"></i> <span>Logout</span></a></li> -->
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <!-- <li class="nav-label">Dashboard</li> -->
                    @if (Str::length(Auth::guard('pelapor')->user()) > 0)
                    <li>
                        <a href="{{url('dashboard-user')}}">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="{{url('profile-pelapor')}}">
                            <i class="fa fa-user"></i><span class="nav-text">Profile</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="{{url('comp')}}">
                            <i class="fa fa-desktop"></i><span class="nav-text">Layanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('history-user')}}">
                            <i class="fa fa-history"></i><span class="nav-text">History</span>
                        </a>
                    </li>
                    @elseif (Str::length(Auth::guard('admin')->user()) > 0)
                    <li>
                        <a href="{{url('dashboard-admin')}}">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('list-akun-admin')}}">
                            <i class="fa fa-users"></i><span class="nav-text">Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('persetujuan-akun-admin')}}">
                            <i class="fa fa-check-square-o"></i><span class="nav-text">Persetujuan Akun</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-files-o"></i> <span class="nav-text">Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('laporan-admin')}}">Laporan Masuk</a></li>
                            <li><a href="{{url('laporan-alihkan')}}">Peralihan Laporan</a></li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a href="{{url('laporan-admin')}}">
                            <i class="fa fa-desktop"></i><span class="nav-text">Laporan Masuk</span>
                        </a>
                    </li> -->
                    <!-- <li>
                        <a href="/send-manager">
                            <i class="fa fa-file-text""></i><span class=" nav-text">Laporan Manager</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="{{url('history-admin')}}">
                            <i class="fa fa-history"></i><span class=" nav-text">History</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-cog"></i> <span class="nav-text">Pengaturan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('kop-surat')}}">Kop Surat</a></li>
                            <li><a href="{{url('broadcast')}}">Broadcast</a></li>
                        </ul>
                    </li>
                    @elseif (Str::length(Auth::guard('teknisi')->user()) > 0)
                    <li>
                        <a href="{{url('profile-teknisi')}}">
                            <i class="fa fa-user"></i><span class="nav-text">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('layanan-it')}}">
                            <i class="fa fa-download"></i><span class="nav-text">Pengajuan Layanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('it')}}">
                            <i class=" fa fa-folder-open"></i><span class="nav-text">Proses Layanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('history-it')}}">
                            <i class="fa fa-history"></i><span class="nav-text">History</span>
                        </a>
                    </li>
                    @elseif (Str::length(Auth::guard('pengawas')->user()) > 0)
                    <li>
                        <a href="{{url('profile-pengawas')}}">
                            <i class="fa fa-user"></i><span class="nav-text">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('list-akun')}}">
                            <i class="fa fa-users"></i><span class="nav-text">Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-folder-o"></i> <span class="nav-text">Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('list-laporan')}}">Daftar Laporan</a></li>
                            <li><a href="{{url('list-laporan-cetak')}}">Print Laporan</a></li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a href="{{url('logout')}}">
                            <i class="fa fa-sign-out"></i><span class="nav-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            @yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{asset('quixlab/plugins/common/common.min.js')}}"></script>
    <script src="{{asset('quixlab/js/custom.min.js')}}"></script>
    <script src="{{asset('quixlab/js/settings.js')}}"></script>
    <script src="{{asset('quixlab/js/gleek.js')}}"></script>
    <script src="{{asset('quixlab/js/styleSwitcher.js')}}"></script>

    <!-- Chartjs -->
    <script src="{{asset('quixlab/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Circle progress -->
    <script src="{{asset('quixlab/plugins/circle-progress/circle-progress.min.js')}}"></script>
    <!-- Datamap -->
    <script src="{{asset('quixlab/plugins/d3v3/index.js')}}"></script>
    <script src="{{asset('quixlab/plugins/topojson/topojson.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/datamaps/datamaps.world.min.js')}}"></script>
    <!-- Morrisjs -->
    <script src="{{asset('quixlab/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/morris/morris.min.js')}}"></script>
    <!-- Pignose Calender -->
    <script src="{{asset('quixlab/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/pg-calendar/js/pignose.calendar.min.js')}}"></script>
    <!-- ChartistJS -->
    <script src="{{asset('quixlab/plugins/chartist/js/chartist.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js')}}"></script>

    <script src="{{asset('quixlab/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>

    <script src="{{asset('quixlab/js/dashboard/dashboard-1.js')}}"></script>

    <script src="{{asset('quixlab/plugins/moment/moment.js')}}"></script>
    <script src="{{asset('quixlab/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="{{asset('quixlab/plugins/clockpicker/dist/jquery-clockpicker.min.js')}}"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="{{asset('quixlab/plugins/jquery-asColorPicker-master/libs/jquery-asColor.js')}}"></script>
    <script src="{{asset('quixlab/plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js')}}"></script>
    <script src="{{asset('quixlab/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js')}}"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{asset('quixlab/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{asset('quixlab/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <script src="{{asset('quixlab/js/plugins-init/form-pickers-init.js')}}"></script>

    <script src="{{asset('quixlab/plugins/sweetalert/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/sweetalert/js/sweetalert.init.js')}}"></script>

    <script src="{{asset('quixlab/plugins/toastr/js/toastr.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/toastr/js/toastr.init.js')}}"></script>

    <!-- Chartjs -->
    <script src="{{asset('quixlab/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Circle progress -->
    <script src="{{asset('quixlab/plugins/circle-progress/circle-progress.min.js')}}"></script>
    <!-- Datamap -->
    <script src="{{asset('quixlab/plugins/d3v3/index.js')}}"></script>
    <script src="{{asset('quixlab/plugins/topojson/topojson.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/datamaps/datamaps.world.min.js')}}"></script>
    <!-- Morrisjs -->
    <script src="{{asset('quixlab/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/morris/morris.min.js')}}"></script>
    <!-- Pignose Calender -->
    <script src="{{asset('quixlab/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/pg-calendar/js/pignose.calendar.min.js')}}"></script>
    <!-- ChartistJS -->
    <script src="{{asset('quixlab/plugins/chartist/js/chartist.min.js')}}"></script>
    <script src="{{asset('quixlab/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js')}}"></script>

    <script src="{{asset('quixlab/js/dashboard/dashboard-1.js')}}"></script>

    @yield('script')
</body>

</html>