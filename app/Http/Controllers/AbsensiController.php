<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function create()
    {
        $hariini        = date("Y-m-d");
        $nik            = Auth::guard('karyawan')->user()->nik;
        $cek            = DB::table('absensi')->where('tgl_absen', $hariini)->where('nik', $nik)->count();
        $lok_kantor     = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('absensi.create', compact('cek', 'lok_kantor'));
    }

    public function store(Request $request)
    {
        $nik            = Auth::guard('karyawan')->user()->nik;
        $tgl_absen      = date("Y-m-d");
        $jam            = date("H:i:s");
        $lok_kantor     = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $lok            = explode(",", $lok_kantor->lokasi_kantor);

        $latitudekantor = $lok[0];
        $longitudekantor= $lok[1];
        $lokasi         = $request->lokasi;
        $lokasiUser     = explode(",", $lokasi);
        $latitudeUser   = $lokasiUser[0];
        $longitudeUser  = $lokasiUser[1];

        $jarak          = $this->distance($latitudekantor, $longitudekantor, $latitudeUser, $longitudeUser);
        $radius         = round($jarak["meters"]);

        $cek            = DB::table('absensi')->where('tgl_absen', $tgl_absen)->where('nik', $nik)->count();
        
        if ($cek > 0) {
            $ket    = "in";
        }else {
            $ket    = "out";
        }

        $image          = $request->image;
        $folderPath     = "public/uploads/absensi/";
        $formatName     = $nik . "-" . $tgl_absen . "-" . $ket;
        $image_parts    = explode(";base64", $image);
        $image_base64   = base64_decode($image_parts[1]);
        $fileName       = $formatName . ".png";
        $file           = $folderPath . $fileName;

        if($radius > $lok_kantor->radius){
            echo "echo|Maaf Anda Berada Diluar Radius, Jarak Anda ".$radius." Meter Dari Kantor|radius";
        }else{

        if($cek > 0)
        {
            $data_pulang    = [
                'jam_out'    => $jam,
                'foto_out'   => $fileName,
                'lokasi_out' => $lokasi
            ];
            $update = DB::table('absensi')->where('tgl_absen', $tgl_absen)->where('nik', $nik)->update($data_pulang);
            if($update){
                echo "success|Terimakasih, Hati-Hati Di Jalan|out";
                Storage::put($file, $image_base64);
            } else{
                echo "error|Maaf Gagal Absen, Hubungi Tim IT|out";
            }
        } else {
            $data           = [
                'nik'       => $nik,
                'tgl_absen' => $tgl_absen,
                'jam_in'    => $jam,
                'foto_in'   => $fileName,
                'lokasi_in' => $lokasi
            ];
            $simpan         = DB::table('absensi')->insert($data);
            if($simpan){
                echo "success|Terimakasih, Selamat Bekerja|in";
                Storage::put($file, $image_base64);
            } else{
                echo "error|Maaf Gagal Absen, Hubungi Tim IT|in";
            }
        }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik        = Auth::guard('karyawan')->user()->nik;
        $karyawan   = DB::table('karyawan')->where('nik', $nik)->first();
        return view('absensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik            = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap   = $request->nama_lengkap;
        $no_hp   = $request->no_hp;
        $password       = Hash::make($request->password);
        $karyawan   = DB::table('karyawan')->where('nik', $nik)->first();
        if($request->hasFile('foto')){
            $foto       = $nik.".".$request->file('foto')->getClientOriginalExtension();
        } else{
            $foto       = $karyawan->foto;
        }

        if (empty($request->password)){
            $data           = [
                'nama_lengkap'  => $nama_lengkap,
                'no_hp'         => $no_hp,
                'foto'          => $foto,
            ];
        }else {
            $data           = [
                'nama_lengkap'  => $nama_lengkap,
                'no_hp'         => $no_hp,
                'password'      => $password,
                'foto'          => $foto,
            ];
        }

        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'data berhasil di update']);
        } else {
            return Redirect::back()->with(['error' => 'data gagal di update']);
        }
    }

    public function histori()
    {
        $namaBulan      = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('absensi.histori', compact('namaBulan'));
    }

    public function getHistori(Request $request)
    {
        $bulan      = $request->bulan;
        $tahun      = $request->tahun;
        $nik        = Auth::guard('karyawan')->user()->nik;

        $histori    = DB::table('absensi')->whereRaw('MONTH(tgl_absen)="' . $bulan . '"')->whereRaw('YEAR(tgl_absen)="' . $tahun . '"')->where('nik', $nik)->orderBy('tgl_absen')->get();

        return view('absensi.gethistori', compact('histori'));
    }

    public function izin()
    {
        $nik        = Auth::guard('karyawan')->user()->nik;
        $dataIzin   = DB::table('pengajuan_izin')->where('nik', $nik)->get();
        return view('absensi.izin', compact('dataIzin'));
    }

    public function buatIzin()
    {
        return view('absensi.buatIzin');
    }

    public function storeIzin(Request $request)
    {
        $nik            = Auth::guard('karyawan')->user()->nik;
        $tgl_izin       = $request->tgl_izin;
        $status         = $request->status;
        $keterangan     = $request->keterangan;

        $data           = [
            'nik'       => $nik,
            'tgl_izin'  => $tgl_izin,
            'status'    => $status,
            'keterangan'=> $keterangan
        ];

        $simpan         = DB::table('pengajuan_izin')->insert($data);
        if($simpan) {
            return redirect('/absensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/absensi/izin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function absensiMonitoring()
    {
        return view('absensi.monitoring');
    }

    public function getAbsensi(Request $request)
    {
        $tanggal    = $request->tanggal;
        $absensi    = DB::table('absensi')->join('karyawan', 'absensi.nik', '=', 'karyawan.nik')->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')->select('absensi.*', 'karyawan.nama_lengkap', 'departemen.nama_dept')->where('tgl_absen', $tanggal)->get();
        return view('absensi.getabsensi', compact('absensi'));
    }

    public function tampilkanPeta(Request $request)
    {
        $id     = $request->id;
        $absensi= DB::table('absensi')->where('id', $id)->join('karyawan', 'absensi.nik', '=', 'karyawan.nik')->first();
        return view('absensi.showmap', compact('absensi'));
    }

    public function laporan()
    {
        $namaBulan      = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $karyawan       = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('absensi.laporan', compact('namaBulan', 'karyawan'));
    }

    public function cetakLaporan(Request $request)
    {
        $nik    = $request->nik;
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;
        $namaBulan      = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $karyawan   = DB::table('karyawan')->where('nik', $nik)->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')->first();

        $absensi    = DB::table('absensi') ->where('nik', $nik)->whereRaw('MONTH(tgl_absen)="'.$bulan.'"')->whereRaw('YEAR(tgl_absen)="'.$tahun.'"')->orderBy('tgl_absen')->get();

        return view('absensi.cetaklaporan', compact('bulan', 'tahun', 'namaBulan', 'karyawan','absensi'));
    }

    public function rekap()
    {
        $namaBulan      = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        return view('absensi.rekap', compact('namaBulan'));
    }

    public function cetakRekap( Request $request)
    {
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;

        $rekap  = DB::table('absensi')->selectRaw('absensi.nik, nama_lengkap,
        MAX(IF(DAY(tgl_absen) = 1, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_1,
        MAX(IF(DAY(tgl_absen) = 2, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_2,
        MAX(IF(DAY(tgl_absen) = 3, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_3,
        MAX(IF(DAY(tgl_absen) = 4, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_4,
        MAX(IF(DAY(tgl_absen) = 5, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_5,
        MAX(IF(DAY(tgl_absen) = 6, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_6,
        MAX(IF(DAY(tgl_absen) = 7, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_7,
        MAX(IF(DAY(tgl_absen) = 8, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_8,
        MAX(IF(DAY(tgl_absen) = 9, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_9,
        MAX(IF(DAY(tgl_absen) = 10, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_10,
        MAX(IF(DAY(tgl_absen) = 11, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_11,
        MAX(IF(DAY(tgl_absen) = 12, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_12,
        MAX(IF(DAY(tgl_absen) = 13, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_13,
        MAX(IF(DAY(tgl_absen) = 14, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_14,
        MAX(IF(DAY(tgl_absen) = 15, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_15,
        MAX(IF(DAY(tgl_absen) = 16, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_16,
        MAX(IF(DAY(tgl_absen) = 17, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_17,
        MAX(IF(DAY(tgl_absen) = 18, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_18,
        MAX(IF(DAY(tgl_absen) = 19, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_19,
        MAX(IF(DAY(tgl_absen) = 20, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_20,
        MAX(IF(DAY(tgl_absen) = 21, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_21,
        MAX(IF(DAY(tgl_absen) = 22, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_22,
        MAX(IF(DAY(tgl_absen) = 23, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_23,
        MAX(IF(DAY(tgl_absen) = 24, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
        MAX(IF(DAY(tgl_absen) = 25, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_25,
        MAX(IF(DAY(tgl_absen) = 26, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_26,
        MAX(IF(DAY(tgl_absen) = 27, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_27,
        MAX(IF(DAY(tgl_absen) = 28, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_28,
        MAX(IF(DAY(tgl_absen) = 29, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_29,
        MAX(IF(DAY(tgl_absen) = 30, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_30,
        MAX(IF(DAY(tgl_absen) = 31, CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_31
        ')->join('karyawan', 'absensi.nik', '=', 'karyawan.nik')->whereRaw('MONTH(tgl_absen)="'.$bulan.'"')->whereRaw('YEAR(tgl_absen)="'.$tahun.'"')->groupByRaw('absensi.nik,nama_lengkap')->get();

        $namaBulan      = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        return view('absensi.cetakrekap', compact('rekap', 'bulan', 'tahun', 'namaBulan'));
    }

    public function izinsakit()
    {
        $izinsakit  = DB::table('pengajuan_izin')
                    ->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik')
                    ->orderBy('tgl_izin', 'desc')
                    ->get();
        return view('absensi.izinsakit', compact('izinsakit'));
    }

    public function approveizinsakit(Request $request)
    {
        $status_approved    = $request->status_approved;
        $id_izinsakit_form  = $request->id_izinsakit_form;

        $update             = DB::table('pengajuan_izin')->where('id', $id_izinsakit_form)->update([
            'status_approved'   => $status_approved
        ]);
        if($update)
        {
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        }else
        {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function batalkanizinsakit($id)
    {
        $update             = DB::table('pengajuan_izin')->where('id', $id)->update([
            'status_approved'   => 0
        ]);
        if($update)
        {
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        }else
        {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin   = $request->tgl_izin;
        $nik        = Auth::guard('karyawan')->user()->nik;

        $cek        = DB::table('pengajuan_izin')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }
}
