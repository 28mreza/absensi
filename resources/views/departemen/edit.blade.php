<form action="/departemen/{{ $departemen->kode_dept }}/update" method="POST" id="formDepartemen" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group position-relative has-icon-left">
                <input type="text" name="kode_dept" class="form-control" placeholder="Kode Departemen" id="kode_dept" value="{{ $departemen->kode_dept }}" readonly>
                <div class="form-control-icon">
                    <i class="bi bi-upc-scan"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group position-relative has-icon-left">
                <input type="text" name="nama_dept" class="form-control" placeholder="Nama Departemen" id="nama_dept" value="{{ $departemen->nama_dept }}">
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