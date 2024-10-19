@extends('template')

@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:history.back()">Layanan</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)"><i>Permintaan Layanan</i></a></li>
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
                        <form action="{{route('save-laporan')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">No Inventaris Aset</label>
                                <div class="col-sm-10">
                                    <input required type="text" value="{{ old('no_inv_aset') }}" name="no_inv_aset" class="form-control" placeholder="Nomor Inventaris Aset">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><b>Periode Pelaporan :</b></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Awal</label>
                                <div class="col-sm-10">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="input-group">
                                                    <input required type="text" value="{{ old('tgl_awal') }}" id="tgl_awal" name="tgl_awal" class="form-control datepicker" placeholder="dd MM yyyy">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                    <input required type="text" value="{{ old('waktu_awal') }}" id="waktu_awal" name="waktu_awal" class="form-control" >
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
                                                    <input required type="text" value="{{ old('tgl_akhir') }}" id="tgl_akhir" name="tgl_akhir" class="form-control datepicker" placeholder="dd MM yyyy">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                    <input required type="text" value="{{ old('waktu_akhir') }}" id="waktu_akhir" name="waktu_akhir" class="form-control"  >
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
                                <label class="col-sm-2 col-form-label"><b>Isi Pelaporan</b></label>
                            </div>
                            <!-- FORM MULTIINPUT -->
                            <div id="laporanInputs">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 17%;">
                                            <label>Kategori/Jenis</label>
                                        </td>
                                        <td colspan="2" style="height: 95px;">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="input-group">
                                                        <select required name="kat_layanan[]" class="form-control kat-layanan">
                                                            <option value="">Pilih satu</option>
                                                            <option value="Throubleshooting">Throubleshooting</option>
                                                            <option value="Instalasi">Instalasi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group" data-placement="bottom" data-align="top" data-autoclose="true">
                                                        <div class="col">
                                                            <select required name="jenis_layanan[]" class="form-control jenis-layanan">
                                                            </select>
                                                        </div>
                                                        <div class="col lainnya-input" style="display: none;">
                                                            <input type="text" name="layanan_lain[]" class="form-control" placeholder="Jenis Layanan Lainnya">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <label>Permasalahan</label>
                                        </td>
                                        <td>
                                            <textarea required style="height: 120px;" name="det_layanan[]" class="form-control det-layanan" placeholder="Masukkan detail permasalahan"></textarea>
                                        </td>
                                        <td align="center">
                                            <!-- Tombol hapus disini dihapus -->
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- END FORM MULTIINPUT -->
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                            <button type="button" id="addLaporan" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="Tambah Laporan"><i class="fa fa-plus" aria-hidden="true"></i></button>
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

        // Set initial date for tgl_awal
        $("#tgl_awal").val(formattedToday);

        // Calculate the date 2 days after today
        var twoDaysLater = new Date();
        twoDaysLater.setDate(today.getDate() + 2);
        var formattedTwoDaysLater = formatDate(twoDaysLater);

        // Set initial date for tgl_akhir
        $("#tgl_akhir").val(formattedTwoDaysLater);

        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function() {
            var date = $(this).datepicker('getDate');
            $(this).val(formatDate(date));
        });

        // Set datepicker options for tgl_awal
        $("#tgl_awal").datepicker('setStartDate', today);

        // Update tgl_akhir when tgl_awal changes
        $("#tgl_awal").on('changeDate', function(selected) {
            var startDate = new Date(selected.date.valueOf());
            var formattedStartDate = formatDate(startDate);

            // Set the formatted date to the input
            $("#tgl_awal").val(formattedStartDate);

            // Calculate the date 2 days after the selected start date
            var endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + 2);
            var formattedEndDate = formatDate(endDate);

            // Update tgl_akhir and set the new start date
            $("#tgl_akhir").datepicker('setStartDate', startDate);
            $("#tgl_akhir").val(formattedEndDate);
        });

        // Initialize the datepicker again to ensure the correct format
        $("#tgl_awal").datepicker('update', today);
        $("#tgl_akhir").datepicker('update', twoDaysLater);
    });

    $(function() {
        function formatTime(date) {
            var hours = ('0' + date.getHours()).slice(-2);
            var minutes = ('0' + date.getMinutes()).slice(-2);
            return hours + ':' + minutes;
        }

        var now = new Date();
        var formattedTime = formatTime(now);

        // Set initial time for waktu_awal and waktu_akhir
        $("#waktu_awal").val(formattedTime);
        $("#waktu_akhir").val(formattedTime);

        $('.clockpicker').clockpicker({
            autoclose: true,
            'default': formattedTime
        });
    });


    function showJenisLayanan(selectElement) {
        var selectedOption = selectElement.value;
        var jenisDropdown = selectElement.closest('.form-row').querySelector('.jenis-layanan');
        var lainnyaInput = selectElement.closest('.form-row').querySelector('.lainnya-input');

        // Mengambil semua kategori yang telah dipilih
        var selectedKategori = [];
        document.querySelectorAll('.kat-layanan').forEach(function(selectElement) {
            if (selectElement.value !== "") {
                selectedKategori.push(selectElement.value);
            }
        });

        // Hapus opsi sebelumnya
        jenisDropdown.innerHTML = "";

        var options = [];

        if (selectedOption === 'Throubleshooting') {
            options = ["Aplikasi", "Jaringan", "PC/Laptop", "Printer", "Lainnya"];
        } else if (selectedOption === 'Instalasi') {
            options = ["Aplikasi", "Sistem Operasi", "Jaringan", "PC/Laptop", "Printer", "Lainnya"];
        }

        options.forEach(function(option) {
            // Periksa apakah opsi sudah dipilih sebelumnya, jika sudah, lewati
            if (!selectedKategori.includes(option)) {
                var opt = document.createElement('option');
                opt.value = option;
                opt.innerHTML = option;
                jenisDropdown.appendChild(opt);
            }
        });

        jenisDropdown.style.display = 'block';
        lainnyaInput.style.display = 'none';
    }

    function showLainnya(selectElement) {
        var selectedOption = selectElement.value;
        var lainnyaInput = selectElement.closest('.form-row').querySelector('.lainnya-input');

        if (selectedOption === 'Lainnya') {
            lainnyaInput.style.display = 'block';
        } else {
            lainnyaInput.style.display = 'none';
        }
    }

    document.getElementById('addLaporan').addEventListener('click', function() {
        var laporanInputs = document.getElementById('laporanInputs');
        var clonedInput = laporanInputs.firstElementChild.cloneNode(true);

        // Kosongkan nilai input pada form yang baru ditambahkan
        clonedInput.querySelectorAll('input, textarea').forEach(function(inputElement) {
            inputElement.value = '';
        });

        laporanInputs.appendChild(clonedInput);

        // Mendaftarkan event listener untuk dropdown baru yang ditambahkan
        clonedInput.querySelectorAll('.kat-layanan').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                showJenisLayanan(this);
            });
        });

        clonedInput.querySelectorAll('.jenis-layanan').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                showLainnya(this);
            });
        });

        var deleteButton = document.createElement('button');
        deleteButton.setAttribute('type', 'button');
        deleteButton.setAttribute('class', 'btn btn-danger remove-laporan');
        deleteButton.setAttribute('data-toggle', 'tooltip');
        deleteButton.setAttribute('data-placement', 'right');
        deleteButton.setAttribute('title', 'Hapus Laporan');
        deleteButton.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';
        deleteButton.addEventListener('click', function() {
            this.closest('table').remove();
        });

        clonedInput.querySelector('tr:nth-child(2) td:last-child').appendChild(deleteButton);
    });

    document.querySelectorAll('.kat-layanan').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            showJenisLayanan(this);
        });
    });

    document.querySelectorAll('.jenis-layanan').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            showLainnya(this);
        });
    });
</script>
@endsection