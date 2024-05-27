<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanBarangController;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/aset', function () {
    return view('layouts.main');
});

// Route pengajuan barang
Route::resource('pengajuan', PengajuanBarangController::class);
// Approved Pengajuan Barang
Route::post('/pengajuan/{id}/approve', [PengajuanBarangController::class, 'approve'])->name('pengajuan.approve');
Route::post('/pengajuan/{id}/reject', [PengajuanBarangController::class, 'reject'])->name('pengajuan.reject');


