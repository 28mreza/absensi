@extends('layouts.admin.app')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Cabang</h3>
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
            <a href="#" class="btn btn-outline-primary btn-sm mb-2" id="btnTambahCabang">
                Tambah Data
            </a>
            <table class="table table-hover text-center" id="table1">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Cabang</th>
                        <th class="text-center">Nama Cabang</th>
                        <th class="text-center">Lokasi Kantor</th>
                        <th class="text-center">Radius</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cabang as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->kode_cabang }}</td>
                        <td>{{ $row->nama_cabang }}</td>
                        <td>{{ $row->lokasi_kantor }}</td>
                        <td>{{ $row->radius }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="#" class="edit btn icon icon-left btn-warning" kode_cabang="{{ $row->kode_cabang }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/cabang/{{ $row->kode_cabang }}/delete" style="margin-left: 5px" method="POST">
                                    @csrf
                                    <a class="btn icon icon-left btn-danger delete-confirm">
                                        <i class="bi bi-trash"></i>
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
<div class="modal fade text-left" id="modal-inputcabang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Tambah Data Cabang
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/cabang/store') }}" method="POST" id="formCabang" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="kode_cabang" class="form-control" placeholder="Kode Cabang" id="kode_cabang">
                                <div class="form-control-icon">
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="nama_cabang" class="form-control" placeholder="Nama Cabang" id="nama_cabang">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="lokasi_kantor" class="form-control" placeholder="Lokasi Cabang" id="lokasi_kantor">
                                <div class="form-control-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="radius" class="form-control" placeholder="Radius" id="radius">
                                <div class="form-control-icon">
                                    <i class="bi bi-broadcast"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text"  class="form-control" value="meter" readonly>
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
<div class="modal fade text-left" id="modal-editcabang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Edit Data Cabang
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
        $("#btnTambahCabang").click(function() {
            $("#modal-inputcabang").modal("show"); 
        });

        $(".edit").click(function() {
            var kode_dept     = $(this).attr('kode_dept');
            $.ajax({
                type: 'POST',
                url: '/cabang/edit',
                cache: false,
                data:{
                    _token: "{{ csrf_token() }}",
                    kode_dept: kode_dept
                },
                success:function(respond){
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editcabang").modal("show"); 
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

        $("#formCabang").submit(function(){
            var kode_cabang     = $("#kode_cabang").val();
            var nama_cabang     = $("#nama_cabang").val();
            var lokasi_kantor   = $("#lokasi_kantor").val();
            var radius          = $("#radius").val();
            if(kode_cabang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Kode Cabang Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#kode_cabang").focus();
                return false;
            } else if(nama_cabang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Cabang Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#nama_cabang").focus();
                return false;
            } else if(lokasi_kantor == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Lokasi Kantor Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#lokasi_kantor").focus();
                return false;
            } else if(radius == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Radius Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#radius").focus();
                return false;
            }
        });
    });
</script>
@endpush