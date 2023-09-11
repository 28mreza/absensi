@extends('layouts.admin.app')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Karyawan</h3>
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
            <a href="#" class="btn btn-outline-primary btn-sm mb-2" id="btnTambahKaryawan">
                Tambah Data
            </a>
            <table class="table table-hover text-center" id="table1">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Jabatan</th>
                        <th class="text-center">No HP</th>
                        <th class="text-center">Foto</th>
                        <th class="text-center">Departemen</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawan as $row)
                    @php
                        $path = Storage::url('uploads/karyawan/'.$row->foto);
                    @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nik }}</td>
                            <td>{{ $row->nama_lengkap }}</td>
                            <td>{{ $row->jabatan }}</td>
                            <td>{{ $row->no_hp }}</td>
                            <td>
                                @if (empty($row->foto))
                                <img src="{{ url('assets/img/avatar/null.jpg') }}" width='150px' height='150px' class="rounded">
                                @else
                                <img src="{{ url($path) }}" width='150px' height='150px' class="rounded">
                                @endif
                            </td>
                            <td>{{ $row->nama_dept }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="edit btn btn-outline-warning" nik="{{ $row->nik }}">
                                        Edit
                                    </a>
                                    <form action="/karyawan/{{ $row->nik }}/delete" style="margin-left: 5px" method="POST">
                                        @csrf
                                        <a class="btn btn-outline-danger delete-confirm">
                                            Hapus
                                        </a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--primary theme Modal -->
<div class="modal fade text-left" id="modal-inputkaryawan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Tambah Data Karyawan
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/karyawan/store') }}" method="POST" id="formKaryawan" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="nik" class="form-control" placeholder="NIK" id="nik">
                                <div class="form-control-icon">
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" id="nama_lengkap">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" id="jabatan">
                                <div class="form-control-icon">
                                    <i class="bi bi-capslock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="no_hp" class="form-control" placeholder="No. HP" id="no_hp">
                                <div class="form-control-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control" type="file" name="foto" id="foto">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mt-3">
                                <label class="input-group-text" for="inputGroupSelect01">Departemen</label>
                                <select class="form-select" name="kode_dept" id="kode_dept">
                                    @foreach ($departemen as $row)
                                    <option {{ Request('kode_dept')==$row->kode_dept ? 'selected' : '' }} value="{{ $row->kode_dept }}" >{{ $row->nama_dept }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit-->
<div class="modal fade text-left" id="modal-editkaryawan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Edit Data Karyawan
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
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnTambahKaryawan").click(function() {
            $("#modal-inputkaryawan").modal("show"); 
        });

        $(".edit").click(function() {
            var nik     = $(this).attr('nik');
            $.ajax({
                type: 'POST',
                url: 'karyawan/edit',
                cache: false,
                data:{
                    _token: "{{ csrf_token() }}",
                    nik: nik
                },
                success:function(respond){
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editkaryawan").modal("show"); 
        });

        $(".delete-confirm").click(function(e){
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin Data ini akan Hapus?',
                text: "Jika Ya Maka Data Akan Terhapus Permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Saja!'
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                    'Terhapus!',
                    'Data Berhasil Di Hapus.',
                    'success'
                    )
                }
            })
        })

        $("#formKaryawan").submit(function(){
            var nik             = $("#nik").val();
            var nama_lengkap    = $("#nama_lengkap").val();
            var jabatan         = $("#jabatan").val();
            var no_hp           = $("#no_hp").val();
            var kode_dept       = $("#kode_dept").val();
            if(nik == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'NIK Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#nik").focus();
                return false;
            } else if(nama_lengkap == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#nama_lengkap").focus();
                return false;
            } else if(jabatan == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jabatan Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#jabatan").focus();
                return false;
            } else if(no_hp == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'No HP Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#no_hp").focus();
                return false;
            } else if(kode_dept == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Departemen Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#kode_dept").focus();
                return false;
            }
        });
    });
</script>
@endpush