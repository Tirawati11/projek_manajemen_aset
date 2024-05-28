<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\LocationController;
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
// Route peminjaman barang
Route::resource('peminjaman', PeminjamanBarangController::class);

// Route Lokasi
Route::resource('lokasi', LocationController::class);


