@extends('layouts.app')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 460px !important;
    }

    .datepicker-date-display{
        background-color: #15689c !important;
    }
</style>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Pengajuan Izin</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
<div class="row" style="margin-top: 4rem">
    <div class="col">
        @php
        $messageSuccess = Session::get('success'); 
        $messageError = Session::get('error');
        @endphp
        @if(Session::get('success'))
        <div class="alert alert-success">
            {{ $messageSuccess }}
        </div>
        @endif
        @if(Session::get('error'))
        <div class="alert alert-danger">
            {{ $messageError }}
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col">
        <form action="{{ url('/absensi/storeizin') }}" method="POST" enctype="multipart/form-data" id="formIzin">
            @csrf
            <div class="col">
                <div class="form-group">
                    <input type="text" class="datepicker"  name="tgl_izin" id="tgl_izin" placeholder="Tanggal Pengajuan" autocomplete="off">
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">Izin / Sakit</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="keterangan"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">ajukan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"    
        });

        $("#tgl_izin").change(function(e){
            var tgl_izin = $(this).val();
            $.ajax({
                type: 'POST',
                url: '/absensi/cekpengajuanizin',
                data: {
                    _token: "{{ csrf_token() }}",
                    tgl_izin: tgl_izin
                },
                cache: false,
                success: function(respond){
                    if(respond == 1){
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Anda Sudah Melakukan Input Pengajuan Izin Pada Tanggal Tersebut!',
                            icon: 'warning',
                        }).then((result)=> {
                            $("#tgl_izin").val("");
                        });
                    }
                }
            });
        });

        $("#formIzin").submit(function() {
        var tgl_izin = $("#tgl_izin").val();
        var status = $("#status").val();
        var keterangan = $("#keterangan").val();
        if(tgl_izin == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Tanggal Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'OK'
            })
            return false;
        } else if(status == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Status Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'OK'
            })
            return false;
        } else if(keterangan == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Keterangan Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'OK'
            })
            return false;
        }
        });
    });
</script>
@endpush