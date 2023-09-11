@if ($histori->isEmpty())
<div class="alert alert-outline-warning">
    <p>Data Tidak Ada</p>
</div>
@endif
@foreach ($histori as $row)
<ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path   = Storage::url('uploads/absensi/'.$row->foto_in);
            @endphp
            <img src="{{ url($path) }}" alt="image" class="image">
            <div class="in">
                <div>
                    <b>{{ date("d-m-Y", strtotime($row->tgl_absen)) }}</b> <br>
                </div>
                <span class="badge {{ $row->jam_in < "07:00" ? "bg-success" : "bg-danger" }}">{{ $row->jam_in }}</span>
                <span class="badge badge-success">{{ $row->jam_out != null && $row->jam_out != null ? $row->jam_out : 'Belum Absen' }}</span>
            </div>
        </div>
    </li>
</ul>
@endforeach