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
            margin-top: 20px;
            border-collapse: collapse;
        }
        .tabelabsensi th {
            border: 1px solid rgb(0, 0, 0);
            padding: 8px;
            background-color: #a6d5ff;
            font-size: 10px;
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
    <body class="legal landscape">
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
                        REKAP ABSENSI KARYAWAN<br>
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
        <table class="tabelabsensi">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">Total Hadir</th>
                <th rowspan="2">Total Terlambat</th>
            </tr>
            <tr>
                <?php
                for ($i=1; $i <= 31; $i++) { 
                ?>
                <th>{{ $i }}</th>
                <?php
                }
                ?>
            </tr>
            @foreach ($rekap as $row)
            <tr>
                <td>{{ $row->nik }}</td>
                <td>{{ $row->nama_lengkap }}</td>
                <?php
                $totalHadir     = 0;
                $totalTerlambat = 0;
                for ($i=1; $i <= 31; $i++) { 
                    $tgl = "tgl_".$i;
                    if (empty($row->$tgl)) {
                        $hadir = ['',''];
                        $totalHadir +=0;
                    }else {
                        $hadir = explode("-",$row->$tgl);
                        $totalHadir +=1;
                        if($hadir[0] > "07:00:00") {
                            $totalTerlambat +=1;
                        }
                    }
                ?>
                <td>
                    <span style="color: {{ $hadir[0] > "07:00:00" ? "red" : "" }}">{{ $hadir[0] }}</span> <br>
                    <span style="color: {{ $hadir[1] < "16:00:00" ? "red" : "" }}">{{ $hadir[1] }}</span>
                </td>
                <?php
                }
                ?>
                <td align="center">{{ $totalHadir }}</td>
                <td align="center">{{ $totalTerlambat }}</td>
            </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td></td>
                <td style="text-align: center">Sukabumi, {{ date('d-m-Y') }}</td>
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