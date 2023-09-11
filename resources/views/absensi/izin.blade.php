@extends('layouts.app')
@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Data Izin / Sakit</div>
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
        @foreach ($dataIzin as $row)
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="in">
                        <div>
                            <b>{{ date("d-m-Y", strtotime($row->tgl_izin)) }} ({{ $row->status == "s" ? "Sakit" : "Izin" }})</b> <br>
                            <small class="text-muted">{{ $row->keterangan }}</small>
                        </div>
                        @if ($row->status_approved == 0)
                            <span class="badge bg-warning">Waiting</span>
                        @elseif($row->status_approved == 1)
                            <span class="badge bg-success">Approved</span>
                        @elseif($row->status_approved == 2)
                            <span class="badge bg-danger">Decline</span>
                        @endif
                    </div>
                </div>
            </li>
        </ul>
        @endforeach
    </div>
</div>
<div class="fab-button bottom-right" style="margin-bottom: 70px">
    <a href="{{ url('/absensi/buatizin') }}" class="fab">
        <ion-icon name="add-outline"></ion-icon>
    </a>
</div>
@endsection