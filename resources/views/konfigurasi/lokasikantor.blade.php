@extends('layouts.admin.app')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Konfigurasi Lokasi Kantor</h3>
            </div>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-6">
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
                    <form action="/konfigurasi/updatelokasikantor" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group position-relative has-icon-left">
                                    <input type="text" name="lokasi_kantor" class="form-control" placeholder="Lokasi Kantor" id="lokasi_kantor" value="{{ $lok_kantor->lokasi_kantor }}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-map"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <div class="form-group position-relative has-icon-left">
                                    <input type="text" name="radius" class="form-control" placeholder="Radius" id="radius" value="{{ $lok_kantor->radius }}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-broadcast"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control" placeholder="Meter" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-outline-primary btn-block">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection