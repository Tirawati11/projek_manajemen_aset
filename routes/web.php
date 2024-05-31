<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PengajuanBarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AsetController;


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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/dashboard', function () {
//         return view('layouts.dashboard.index');
//     })->name('dashboard');
// });

// Route::get('/not-activated', function () {
//     return view('form.not-activated');
// })->name('not-activated');


// cetak laporan
Route::get('/laporan', [LaporanController::class, 'laporan']);
//Route User
Route::resource('users', UserController::class);
Route::put('users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
Route::get('/users/create', 'UserController@create')->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/users/{id}', 'UserController@destroy')->name('users.delete');

//Route Category
Route::resource('categories', CategoryController::class);
Route::get('/categories/{id}/edit', 'CategoryController@edit');
// Route pengajuan barang
Route::resource('pengajuan', PengajuanBarangController::class);
// Approved Pengajuan Barang
Route::post('/pengajuan/{id}/approve', [PengajuanBarangController::class, 'approve'])->name('pengajuan.approve');
Route::post('/pengajuan/{id}/reject', [PengajuanBarangController::class, 'reject'])->name('pengajuan.reject');


//Route LoginRegister
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::delete('/logout', [AuthController::class, 'logout']);


// Route Aset
Route::resource('aset', AsetController::class);
Route::get('/get-nama-barang/{kode_id}', [AsetController::class, 'getNamaBarang']);
