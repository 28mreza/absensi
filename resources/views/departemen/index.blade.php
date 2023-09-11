@extends('layouts.admin.app')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Departemen</h3>
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
            <a href="#" class="btn btn-outline-primary btn-sm mb-2" id="btnTambahDepartemen">
                Tambah Data
            </a>
            <table class="table table-hover text-center" id="table1">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Departemen</th>
                        <th class="text-center">Nama Departemen</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($departemen as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->kode_dept }}</td>
                        <td>{{ $row->nama_dept }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="#" class="edit btn icon icon-left btn-warning" kode_dept="{{ $row->kode_dept }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="/departemen/{{ $row->kode_dept }}/delete" style="margin-left: 5px" method="POST">
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
<div class="modal fade text-left" id="modal-inputdepartemen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">
                    Tambah Data Departemen
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/departemen/store') }}" method="POST" id="formDepartemen" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="kode_dept" class="form-control" placeholder="Kode Departemen" id="kode_dept">
                                <div class="form-control-icon">
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="nama_dept" class="form-control" placeholder="Nama Departemen" id="nama_dept">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
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
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnTambahDepartemen").click(function() {
            $("#modal-inputdepartemen").modal("show"); 
        });

        $(".edit").click(function() {
            var kode_dept     = $(this).attr('kode_dept');
            $.ajax({
                type: 'POST',
                url: '/departemen/edit',
                cache: false,
                data:{
                    _token: "{{ csrf_token() }}",
                    kode_dept: kode_dept
                },
                success:function(respond){
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editdepartemen").modal("show"); 
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

        $("#formDepartemen").submit(function(){
            var kode_dept       = $("#kode_dept").val();
            var nama_dept    = $("#nama_dept").val();
            if(kode_dept == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Kode Departemen Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#kode_dept").focus();
                return false;
            } else if(nama_dept == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Departemen Harus Diisi',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $("#nama_dept").focus();
                return false;
            }
        });
    });
</script>
@endpush