<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CabangController extends Controller
{
    public function index()
    {
        $cabang         = DB::table('cabang')->get();
        return view('cabang.index', compact('cabang'));
    }

    public function store(Request $request)
    {
        $kode_cabang    = $request->kode_cabang;
        $nama_cabang    = $request->nama_cabang;
        $lokasi_kantor  = $request->lokasi_kantor;
        $radius         = $request->radius;

        $simpan         = DB::table('cabang')->insert([
            'kode_cabang'   => $kode_cabang,
            'nama_cabang'   => $nama_cabang,
            'lokasi_kantor' => $lokasi_kantor,
            'radius'        => $radius,
        ]);

        if($simpan)
        {
            return Redirect::back()->with(['success' => 'Data Berhasil Ditambahkan']);
        } else{
            return Redirect::back()->with(['warning' => 'Data Gagal Ditambahkan']);
        }
    }
}
