@php
function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
@endphp
@foreach ($absensi as $row)
@php
    $foto_in    = Storage::url('uploads/absensi/'.$row->foto_in);
    $foto_out   = Storage::url('uploads/absensi/'.$row->foto_out);
@endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->nik }}</td>
        <td>{{ $row->nama_lengkap }}</td>
        <td>{{ $row->nama_dept }}</td>
        <td>{{ $row->jam_in }}</td>
        <td>
            <img src="{{ url($foto_in) }}" width='100px' height='100px' class="rounded">
        </td>
        <td>{!! $row->jam_out != null ? $row->jam_out : '<span class="badge bg-danger">Belum Absen</span>' !!}</td>
        <td>
            @if ($row->foto_out != null)
            <img src="{{ url($foto_out) }}" width='100px' height='100px' class="rounded">
            @else
            <i class="bi bi-hourglass"></i>
            @endif
        </td>
        <td>
            @if ($row->jam_in >= '07:00')
            @php
            $jamterlambat = selisih('07:00:00',$row->jam_in)
            @endphp
            <span class="badge bg-danger">Terlambat {{ $jamterlambat }}</span>
            @else
            <span class="badge bg-success">Tepat Waktu</span>
            @endif
        </td>
        <td>
            <a href="#" class="btn icon icon-left btn-primary tampilkanpeta" id="{{ $row->id }}">
                <i class="bi bi-geo-alt-fill"></i>
            </a>
        </td>
    </tr>
@endforeach

<script>
    $(function(){
        $(".tampilkanpeta").click(function(e){
            var id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '/tampilkanpeta',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success:function(respond){
                    $("#loadmap").html(respond);
                }
            });
            $("#modal-tampilkanpeta").modal("show");
        });
    });
</script>