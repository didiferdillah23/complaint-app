@extends('template')

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        <!-- Konten 3 (6 dari 12) dengan flexbox untuk rowspan efek -->
        <div class="col-lg-6 col-12 flex-column-half">
            <div class="row">
                <!-- Kolom pertama dalam Konten 3 -->
                <div class="col-6">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <h3 class="card-title text-white">Open</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{$open}}</h2>
                                <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-repeat"></i></span>
                        </div>
                    </div>
                </div>
                <!-- Kolom kedua dalam Konten 3 -->
                <div class="col-6">
                    <div class="card gradient-3">
                        <div class="card-body">
                            <h3 class="card-title text-white">Process</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{$proses}}</h2>
                                <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-pencil"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-auto">
                <div class="col-6">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Postponed</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{$ditunda}}</h2>
                                <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-ban"></i></span>
                        </div>
                    </div>
                </div>
                <!-- Kolom kedua dalam Konten 4 -->
                <div class="col-6">
                    <div class="card gradient-4">
                        <div class="card-body">
                            <h3 class="card-title text-white">Closed</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{$selesai}}</h2>
                                <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-check-square"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Konten 1 (6 dari 12) -->
        <div class="col-lg-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Broadcast</h4>
                    <div id="activity">
                        @foreach ($bc as $dt)
                        <div class="media border-bottom-1 pt-3 pb-3">
                            <div class="media-body">
                                <h5>{{$dt->judul}}</h5>
                                <p class="mb-0">{{$dt->informasi}}</p>
                            </div><span class="text-muted ">{{$dt->tgl_tampil}}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <table>
        <tr>
            <td>KOnten 1</td>
            <td>Konten 2</td>
            <td rowspan="2" colspan="2">Konten 5</td>
        </tr>
        <tr>
            <td>Konten 3</td>
            <td>Konten 4</td>
        </tr>
    </table> -->


</div>
@endsection