@extends('template')
@section('content')
<div class="container-fluid">
    @if(Session::has('success'))
    <div class="toastr-trigger" data-type="success" data-message="{{ Session::get('success') }}" data-position-class="Berhasil"></div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Email Tembusan</h4>

                <!-- modal add data -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah</button>

                <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                    aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Tambah Email Tembusan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{url('email-tembusan')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table style="color: #2D3134;"
                                class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    @foreach($listEmailTembusan as $emailTembusan)
                                    <?php $no++ ?>
                                    <tr>
                                        <td>{{$no}}</td>
                                        <td>{{$emailTembusan->email}}</td>
                                        <td>
                                            <a href="{{url('delete-email-tembusan',$emailTembusan->id)}}"
                                                onclick="return confirm('Apakah Yakin Hapus Data Ini?')"
                                                style="color: #ffffff;"><button class="btn btn-danger btn-sm"><i
                                                        class="fa fa-trash"></i></button"></a>
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
@endsection
