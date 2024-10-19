@extends('template')

@section('content')
<div class="container-fluid">
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button> <strong>Laporan Diselesaikan !</strong> {{ Session::get('success') }}
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex bd-highlight mb-3">
                        <div class="mr-auto p-2 bd-highlight">
                            <h3>Permintaan Layanan</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table style="color: #2D3134;" class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Permintaan</th>
                                    <th>Nama Pelapor</th>
                                    <th>No Inventaris</th>
                                    <th>Batas Akhir Pengerjaan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach ($dtLap as $data)
                                <?php $no++ ?>
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{ $data->tgl_masuk }}</td>
                                    <td>{{ $data->nama_pelapor }}</td>
                                    <td>{{ $data->no_inv_aset }}</td>
                                    <td>
                                        @if($data->waktu_tambahan != null)
                                        <?php
                                        $tanggalDeadline        = $data->deadline;
                                        $waktu_tambahan         = $data->waktu_tambahan;
                                        $tanggalBaruTimestamp   = strtotime(date('Y-m-d H:i', strtotime(str_replace('-', '/', $tanggalDeadline))) . " +$waktu_tambahan days");
                                        $tanggalBaru_format     = date('d M Y', $tanggalBaruTimestamp) . ', ' . date('H:i', $tanggalBaruTimestamp) . ' WIB';
                                        $tanggalBaru            = date('d-m-Y', $tanggalBaruTimestamp);
                                        ?>
                                        <!-- MENAMPILKAN TANGGAL BARU SETELAH PENAMBAHAN WAKTU -->
                                        <span style="color: #3167D5;">{{ $tanggalBaru_format }}</span> <br>

                                        <?php
                                        $tanggalDeadlineBaru    = new DateTime($tanggalBaru);
                                        $tanggalHariIni         = new DateTime();
                                        $cekDeadline            = $tanggalHariIni->modify('+1 day');
                                        ?>
                                        @if ($tanggalDeadlineBaru->format('Y-m-d') == $cekDeadline->format('Y-m-d'))
                                        <i style="color: #DF1839; font-size: 12px;">1 hari lagi </i>
                                        @elseif($tanggalDeadlineBaru->format('Y-m-d') < $tanggalHariIni->format('Y-m-d'))
                                            <i style="color: #DF1839; font-size: 12px;">Telah melewati batas waktu</i>
                                            @endif

                                            @else
                                            {{ $data->tgl_akhir_pengerjaan }} <br>
                                            <?php
                                            $tanggalDeadline        = $data->deadline;
                                            $tanggalDeadlineBaru    = new DateTime($tanggalDeadline);
                                            $tanggalHariIni         = new DateTime();
                                            $cekDeadline            = $tanggalHariIni->modify('+1 day');
                                            ?>
                                            @if ($tanggalDeadlineBaru->format('Y-m-d') == $cekDeadline->format('Y-m-d'))
                                            <i style="color: #DF1839; font-size: 12px;">1 hari lagi </i>
                                            @elseif($tanggalDeadlineBaru->format('Y-m-d') < $tanggalHariIni->format('Y-m-d'))
                                                <i style="color: #DF1839; font-size: 12px;">Telah melewati batas waktu</i>
                                                @endif

                                                @endif
                                    </td>

                                    <td>
                                        @if($data->status_terakhir == 'Pengajuan')
                                        <span class="badge badge-primary">Open</span>
                                        @elseif($data->status_terakhir == 'Diproses')
                                        <span class="badge badge-info">Diproses</span>
                                        @elseif($data->status_terakhir == 'CheckedU' or $data->status_terakhir == 'CheckLapU' or $data->status_terakhir == 'reqAddTime')
                                        <span class="badge badge-warning">Postponed</span>
                                        @elseif($data->status_terakhir == 'ReqHapus')
                                        <span class="badge badge-warning">Request <i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                        @elseif($data->status_terakhir == 'Dibatalkan')
                                        <span class="badge badge-danger">Cancel</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('detail-comp-it',$data->id)}}"><button class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></button></a>
                                        <!-- <a href="{{url('delete-laporan',$data->id)}}" onclick="return confirm('Apakah Yakin Hapus Data Ini?')" style="color: #C63F56;"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a> -->
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        <!-- ========= MODAL ========= -->

                        <!-- ========= END MODAL ========= -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection