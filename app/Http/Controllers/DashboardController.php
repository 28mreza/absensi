<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $hariIni        = date("Y-m-d");
        $bulanIni       = date("m") * 1; //1 atau januari
        $tahunIni       = date("Y"); // 2023
        $nik            = Auth::guard('karyawan')->user()->nik;
        $absensiHariini = DB::table('absensi')->where('nik', $nik)->where('tgl_absen', $hariIni)->first();
        $historiBulanini= DB::table('absensi')->where('nik', $nik)->whereRaw('MONTH(tgl_absen)="' . $bulanIni . '"')->whereRaw('YEAR(tgl_absen)="' . $tahunIni . '"')->orderBy('tgl_absen')->get();

        $rekapAbsen     = DB::table('absensi')->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmltelat')->where('nik', $nik)->whereRaw('MONTH(tgl_absen)="' . $bulanIni . '"')->whereRaw('YEAR(tgl_absen)="' . $tahunIni . '"')->first();

        $leaderboard    = DB::table('absensi')->join('karyawan', 'absensi.nik', '=', 'karyawan.nik')->where('tgl_absen', $hariIni)->orderBy('jam_in')->get();
        $namaBulan      = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $rekapIzin      = DB::table('pengajuan_izin')->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')->where('nik', $nik)->whereRaw('MONTH(tgl_izin)="' . $bulanIni . '"')->whereRaw('YEAR(tgl_izin)="' . $tahunIni . '"')->where('status_approved', 1)->first();
        return view('dashboard.dashboard', compact('absensiHariini', 'historiBulanini', 'namaBulan', 'bulanIni', 'tahunIni', 'rekapAbsen', 'leaderboard', 'rekapIzin'));
    }

    public function dashboardAdmin()
    {
        $hariIni        = date("Y-m-d");
        $rekapAbsen     = DB::table('absensi')->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmltelat')->where('tgl_absen', $hariIni)->first();
        $rekapIzin      = DB::table('pengajuan_izin')->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')->where('tgl_izin', $hariIni)->where('status_approved', 1)->first();
        return view('dashboard.dashboardAdmin', compact('rekapAbsen', 'rekapIzin'));
    }
}
