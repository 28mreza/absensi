@extends('layouts.admin.app')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Monitoring Absensi</h3>
            </div>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::get('warning'))
                    <div class="alert alert-warning">
                        {{ Session::get('warning') }}
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal Absensi" autocomplete="off" value="{{ date('Y-m-d') }}">
                                <div class="form-control-icon">
                                    <i class="bi bi-calendar-week"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-hover text-center" id="table1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">NIK</th>
                                        <th class="text-center">Nama Karyawan</th>
                                        <th class="text-center">Departemen</th>
                                        <th class="text-center">Jam Masuk</th>
                                        <th class="text-center">Foto</th>
                                        <th class="text-center">Jam Pulang</th>
                                        <th class="text-center">Foto</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Peta Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadabsensi">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal edit-->
<div class="modal fade text-left" id="modal-editdepartemen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Edit Data Departemen
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body" id="loadeditform">

            </div>
        </div>
    </div>
</div>
{{-- Modal peta --}}
<div class="modal fade text-left" id="modal-tampilkanpeta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Lokasi Absensi User
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body" id="loadmap">

            </div>
        </div>
    </div>
</div>
</section>
@endsection

@push('myscript')
<script>
    $(function () {
        $("#tanggal").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                format: 'yyyy-mm-dd'
        }).datepicker('update', new Date());
    });

    function loadabsensi(){
        var tanggal     = $("#tanggal").val();
        $.ajax({
            type:'POST',
            url: '/getabsensi',
            data:{
                _token:"{{ csrf_token() }}",
                tanggal:tanggal,
            },
            cache:false,
            success:function(respond){
                $("#loadabsensi").html(respond);
            }
        });
    }

    $("#tanggal").change(function(e){
        loadabsensi();
    });

    loadabsensi();
</script>
@endpush