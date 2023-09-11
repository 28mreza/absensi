<form action="/karyawan/{{ $karyawan->nik }}/update" method="POST" id="formKaryawan" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group position-relative has-icon-left">
                <input type="text" name="nik" class="form-control" placeholder="NIK" id="nik" value="{{ $karyawan->nik }}" readonly>
                <div class="form-control-icon">
                    <i class="bi bi-upc-scan"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group position-relative has-icon-left">
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" id="nama_lengkap" value="{{ $karyawan->nama_lengkap }}">
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group position-relative has-icon-left">
                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" id="jabatan" value="{{ $karyawan->jabatan }}">
                <div class="form-control-icon">
                    <i class="bi bi-capslock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group position-relative has-icon-left">
                <input type="text" name="no_hp" class="form-control" placeholder="No. HP" id="no_hp" value="{{ $karyawan->no_hp }}">
                <div class="form-control-icon">
                    <i class="bi bi-telephone"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input class="form-control" type="file" name="foto" id="foto">
            <input type="hidden" name="old_foto" value="{{ $karyawan->foto }}">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-group mt-3">
                <label class="input-group-text" for="inputGroupSelect01">Departemen</label>
                <select class="form-select" name="kode_dept" id="kode_dept">
                    @foreach ($departemen as $row)
                    <option {{ $karyawan->kode_dept==$row->kode_dept ? 'selected' : '' }} value="{{ $row->kode_dept }}" >{{ $row->nama_dept }}</option>
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