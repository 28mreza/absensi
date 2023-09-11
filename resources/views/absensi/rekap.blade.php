@extends('layouts.admin.app')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Rekap Absensi</h3>
            </div>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="/absensi/cetakrekap" target="_blank" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="bulan" id="bulan" class="form-select">
                                        <option value="">Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ date("m") ==$i ? 'selected' : ''}}>{{ $namaBulan[$i] }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="tahun" id="tahun" class="form-select">
                                        <option value="">Tahun</option>
                                        @php
                                        $tahunMulai     = 2022;
                                        $tahunSkrg      = date("Y");
                                        @endphp
                                        @for ($tahun = $tahunMulai; $tahun <=$tahunSkrg; $tahun++)
                                        <option value="{{ $tahun }}" {{ date("Y") ==$tahun ? 'selected' : ''}}>{{ $tahun }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" name="cetak" class="btn btn-outline-primary w-100">
                                        Cetak
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" name="exportexcel" class="btn btn-outline-success w-100">
                                        Export Ke Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection