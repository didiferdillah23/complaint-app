@extends('template')

@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:history.back()">Broadcast</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)"><i>Pembuatan Broadcast</i></a></li>
        </ol>
    </div>
</div>
<div class="container-fluid">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button> <strong>Terdapat Data Serupa!</strong> {{ $error }}
    </div>
    @endforeach
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="card-title">Form Permintaan Layanan</h4> -->
                    <div class="basic-form">
                        <form action="{{route('update-broadcast',$bc->id)}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><b>Judul Broadcast</b></label>
                                <div class="col-sm-10">
                                    <input required type="text" value="{{$bc->judul}}" name="judul" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><b>Isi Broadcast</b></label>
                                <div class="col-sm-10">
                                    <textarea required class="form-control" name="informasi"> {{$bc->informasi}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><b>Periode Ditampilkan </b></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Awal</label>
                                <div class="col-sm-10">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="input-group">
                                                    <input required type="text" value="{{$bc->tgl_tampil}}" id="tgl_tampil" name="tgl_tampil" class="form-control datepicker" placeholder="dd MM yyyy">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                    <input required type="text" value="{{$bc->tgl_tampil}}" id="waktu_tampil" name="waktu_tampil" class="form-control" placeholder="hh:mm">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Akhir</label>
                                <div class="col-sm-10">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="input-group">
                                                    <input required type="text" value="{{$bc->tgl_selesai}}" id="tgl_selesai" name="tgl_selesai" class="form-control datepicker" placeholder="dd MM yyyy">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                    <input required type="text" value="{{$bc->tgl_selesai}}" id="waktu_selesai" name="waktu_selesai" class="form-control" placeholder="hh:mm">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(function() {
        function formatDate(date) {
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var year = date.getFullYear();
            return day + '/' + month + '/' + year;
        }

        var today = new Date();
        var formattedToday = formatDate(today);

        // Set initial date for tgl_tampil
        $("#tgl_tampil").val(formattedToday);

        // Calculate the date 2 days after today
        var twoDaysLater = new Date();
        twoDaysLater.setDate(today.getDate() + 7);
        var formattedTwoDaysLater = formatDate(twoDaysLater);

        // Set initial date for tgl_selesai
        $("#tgl_selesai").val(formattedTwoDaysLater);

        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function() {
            var date = $(this).datepicker('getDate');
            $(this).val(formatDate(date));
        });

        // Set datepicker options for tgl_tampil
        $("#tgl_tampil").datepicker('setStartDate', today);

        // Update tgl_selesai when tgl_tampil changes
        $("#tgl_tampil").on('changeDate', function(selected) {
            var startDate = new Date(selected.date.valueOf());
            var formattedStartDate = formatDate(startDate);

            // Set the formatted date to the input
            $("#tgl_tampil").val(formattedStartDate);

            // Calculate the date 2 days after the selected start date
            var endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + 7);
            var formattedEndDate = formatDate(endDate);

            // Update tgl_selesai and set the new start date
            $("#tgl_selesai").datepicker('setStartDate', startDate);
            $("#tgl_selesai").val(formattedEndDate);
        });

        // Initialize the datepicker again to ensure the correct format
        $("#tgl_tampil").datepicker('update', today);
        $("#tgl_selesai").datepicker('update', twoDaysLater);
    });

    $(function() {
        function formatTime(date) {
            var hours = ('0' + date.getHours()).slice(-2);
            var minutes = ('0' + date.getMinutes()).slice(-2);
            return hours + ':' + minutes;
        }

        var now = new Date();
        var formattedTime = formatTime(now);

        // Set initial time for waktu_tampil and waktu_selesai
        $("#waktu_tampil").val(formattedTime);
        $("#waktu_selesai").val(formattedTime);

        $('.clockpicker').clockpicker({
            autoclose: true,
            'default': formattedTime
        });
    });
</script>
@endsection