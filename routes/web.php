<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginAdmin');
    })->name('loginadmin');
    Route::post('/loginadmin', [AuthController::class, 'loginAdmin']);

});

Route::middleware(['auth:karyawan'])->group(function (){
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    // absensi
    Route::get('/absensi/create', [AbsensiController::class, 'create']);
    Route::post('/absensi/store', [AbsensiController::class, 'store']);

    // Edit Profile
    Route::get('/profile/edit', [AbsensiController::class, 'editprofile']);
    Route::post('/absensi/{nik}/profile/update', [AbsensiController::class, 'updateprofile']);

    //histori
    Route::get('/absensi/histori', [AbsensiController::class, 'histori']);
    Route::post('/gethistori', [AbsensiController::class, 'getHistori']);

    //Izin
    Route::get('/absensi/izin', [AbsensiController::class, 'izin']);
    Route::get('/absensi/buatizin', [AbsensiController::class, 'buatIzin']);
    Route::post('/absensi/storeizin', [AbsensiController::class, 'storeIzin']);
    Route::post('/absensi/cekpengajuanizin', [AbsensiController::class, 'cekpengajuanizin']);
});


// Route::get('/admins', function () {
//         return view('layouts.admin.app');
// });

Route::middleware(['auth:user'])->group(function (){
    Route::get('/logoutadmin', [AuthController::class, 'logoutAdmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardAdmin']);

    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);

    //departemen
    Route::get('/departemen', [DepartemenController::class, 'index']);
    Route::post('/departemen/store', [DepartemenController::class, 'store']);
    Route::post('/departemen/edit', [DepartemenController::class, 'edit']);
    Route::post('/departemen/{kode_dept}/update', [DepartemenController::class, 'update']);
    Route::post('/departemen/{kode_dept}/delete', [DepartemenController::class, 'delete']);

    //cabang
    Route::get('/cabang', [CabangController::class, 'index']);
    Route::post('/cabang/store', [CabangController::class, 'store']);

    //absensi
    Route::get('/absensi/monitoring', [AbsensiController::class, 'absensiMonitoring']);
    Route::post('/getabsensi', [AbsensiController::class, 'getAbsensi']);
    Route::post('/tampilkanpeta', [AbsensiController::class, 'tampilkanPeta']);
    Route::get('/absensi/laporan', [AbsensiController::class, 'laporan']);
    Route::get('/absensi/rekap', [AbsensiController::class, 'rekap']);
    Route::post('/absensi/cetaklaporan', [AbsensiController::class, 'cetakLaporan']);
    Route::post('/absensi/cetakrekap', [AbsensiController::class, 'cetakRekap']);
    Route::get('/absensi/izinsakit', [AbsensiController::class, 'izinsakit']);
    Route::post('/absensi/approveizinsakit', [AbsensiController::class, 'approveizinsakit']);
    Route::get('/absensi/{id}/batalkanizinsakit', [AbsensiController::class, 'batalkanizinsakit']);

    //konfigurasi
    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);
});