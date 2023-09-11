<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page { 
            size: A4 
        }
        span.title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }
        table.tabeldatakaryawan {
            margin-top: 40px;
            font-weight: normal;
        }
        .tabeldatakaryawan td {
            padding: 5px;
        }

        .tabelabsensi {
            width: 100%;
            margin-top: 230px;
            border-collapse: collapse;
        }
        .tabelabsensi th {
            border: 1px solid rgb(0, 0, 0);
            padding: 8px;
            background-color: #a6d5ff;
        }
        .tabelabsensi td {
            border: 1px solid rgb(0, 0, 0);
            padding: 5px;
            font-size: 12px;
        }


        hr.garis {
            border: 1.5px solid rgb(0, 0, 0);
        }
    </style>
    </head>

    <!-- Set "A5", "A4" or "A3" for class name -->
    <!-- Set also "landscape" if you need -->
    <body class="A4">
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
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <!-- Write HTML just like a web page -->
        <table style="width: 100%">
            <tr>
                <th style="width: 30px">
                    <img src="{{ asset('assets/img/proxi.png') }}" width="150">
                </th>
                <th>
                    <span class="title">
                        LAPORAN ABSENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }}<br>
                        PT. PROXI JARINGAN NUSANTARA <br>
                    </span>
                    <span>
                        <i>Jl. Sarasa No.1, Kp. Loasari, Sindangpalay, Kec. Cibeureum, Kota Sukabumi</i>
                    </span>
                </th>
            </tr>
        </table>
        <hr class="garis">

        <table class="tabeldatakaryawan" align="left">
            <tr>
                <td rowspan="6">
                    @php
                    $path = Storage::url('uploads/karyawan/'.$karyawan->foto);
                    @endphp
                    <img src="{{ $path }}" width="150">
                </td>
            </tr>
            <tr>
                <td>NIK</td>
                <td> :</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama Karyawan</td>
                <td> :</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td> :</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td> :</td>
                <td>{{ $karyawan->nama_dept }}</td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td> :</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>

        <table class="tabelabsensi" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Keterangan</th>
                <th>Jam Kerja</th>
            </tr>
            @foreach ($absensi as $row)
            @php
            $path_in        = Storage::url('uploads/absensi/'.$row->foto_in);
            $path_out       = Storage::url('uploads/absensi/'.$row->foto_out);
            $jamterlambat   = selisih('07:00:00', $row->jam_in);
            @endphp
            <tr align="center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ date("d-m-Y", strtotime($row->tgl_absen)) }}</td>
                <td>{{ $row->jam_in }}</td>
                <td><img src="{{ $path_in }}" width="20%"></td>
                <td>{{ $row->jam_out != null ? $row->jam_out : 'Belum Absen' }}</td>
                <td>
                    @if ($row->foto_out != null)
                    <img src="{{ url($path_out) }}" width='20%'>
                    @else
                    <img src="{{ asset('assets/img/avatar/null.jpg') }}" width='20%'>
                    @endif
                </td>
                <td>
                    @if ($row->jam_in > '07:00')
                        Terlambat {{ $jamterlambat }}
                    @else
                        Tepat Waktu
                    @endif
                </td>
                <td>
                    @if ($row->jam_out != null)
                    @php
                    $jmljamkerja = selisih($row->jam_in, $row->jam_out);
                    @endphp
                    @else
                    @php
                    $jmljamkerja = 0;
                    @endphp
                    @endif
                    {{ $jmljamkerja }}
                </td>
            </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align: right">Sukabumi, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: bottom" height="100px">
                    <u>Neneng Na'i</u><br>
                    <i><b>HRD Manager</b></i>
                </td>
                <td style="text-align: center; vertical-align: bottom">
                    <u>Akmal</u><br>
                    <i><b>Direktur</b></i>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>