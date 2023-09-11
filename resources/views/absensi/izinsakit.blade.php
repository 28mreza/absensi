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
                            <table class="table table-hover text-center" id="table1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">NIK</th>
                                        <th class="text-center">Nama Karyawan</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Status Approve</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($izinsakit as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($row->tgl_izin)) }}</td>
                                        <td class="text-center">{{ $row->nik }}</td>
                                        <td class="text-center">{{ $row->nama_lengkap }}</td>
                                        <td class="text-center">{{ $row->jabatan }}</td>
                                        <td class="text-center">
                                            {{ $row->status == 'i' ? "Izin" : "Sakit" }}
                                        </td>
                                        <td class="text-center">{{ $row->keterangan }}</td>
                                        <td>
                                            @if ($row->status_approved == 1)
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($row->status_approved == 2)
                                            <span class="badge bg-danger">Ditolak</span>
                                            @else
                                            <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($row->status_approved == 0 )
                                            <a href="#" class="btn btn-outline-primary btn-sm" id="approve" id_izinsakit="{{ $row->id }}">Ubah</a>
                                            @else
                                            <a href="/absensi/{{ $row->id }}/batalkanizinsakit" class="btn btn-outline-danger btn-sm">Batalkan</a>
                                            @endif
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
{{-- Modal Ubah --}}
<div class="modal fade text-left" id="modal-izinsakit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Izin/Sakit
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="/absensi/approveizinsakit/" method="POST">
                    @csrf
                    <input type="hidden" id="id_izinsakit_form" name="id_izinsakit_form">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select class="form-select" name="status_approved" id="status_approved">
                                    <option value="1">Disetujui</option>
                                    <option value="2">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-outline-primary btn-block mt-3" type="submit">
                                    Submit
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

@push('myscript')
<script>
    $(function(){
        $("#approve").click(function(e) {
            e.preventDefault();
            var id_izinsakit = $(this).attr("id_izinsakit");
            $("#id_izinsakit_form").val(id_izinsakit);
            $("#modal-izinsakit").modal("show");
        });

        //Datepicker
        $("#dari, #sampai").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                format: 'yyyy-mm-dd'
        }).datepicker('update', new Date());
    });
</script>
@endpush