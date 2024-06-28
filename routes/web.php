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

// Route::group(['middleware' => 'auth'], function () {
//     // Route Dashboard
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     // cetak laporan
//     Route::get('/laporan', [LaporanController::class, 'laporan']);

//     // Route Users
//     Route::resource('users', UserController::class);
//     Route::put('users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
//     Route::get('/users/create', 'UserController@create')->name('users.create');
//     Route::post('/users', [UserController::class, 'store'])->name('users.store');
//     Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
//     Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
//     Route::delete('/users/{id}', 'UserController@destroy')->name('users.delete');

//     // Route Categories
//     Route::resource('categories', CategoryController::class);
//     Route::get('/categories/{id}/edit', 'CategoryController@edit');

//     // Route Pengajuan Barang
//     Route::resource('pengajuan', PengajuanBarangController::class);
//     Route::post('/pengajuan/{id}/approve', [PengajuanBarangController::class, 'approve'])->name('pengajuan.approve');
//     Route::post('/pengajuan/{id}/reject', [PengajuanBarangController::class, 'reject'])->name('pengajuan.reject');

//     // Route peminjaman barang
//     Route::resource('peminjaman', PeminjamanBarangController::class);

//     // Route Lokasi
//     Route::resource('lokasi', LocationController::class);

//     // Route Aset
//     Route::resource('aset', AsetController::class);
//     Route::get('/get-nama-barang/{kode_id}', [AsetController::class, 'getNamaBarang']);
// });

// //Route LoginRegister

// Route::get('/register', [AuthController::class, 'register'])->name('register');
// Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
// Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
// Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    // Route Pengajuan Barang
    Route::resource('pengajuan', PengajuanBarangController::class);
    Route::post('/pengajuan/{id}/approve', [PengajuanBarangController::class, 'approve'])->name('pengajuan.approve')->middleware('jabatan:admin');
    Route::post('/pengajuan/{id}/reject', [PengajuanBarangController::class, 'reject'])->name('pengajuan.reject')->middleware('jabatan:admin');

    // Route Peminjaman Barang
    Route::resource('peminjaman', PeminjamanBarangController::class);
    Route::resource('users', UserController::class);

    // Middleware Admin Only
    Route::group(['middleware' => 'jabatan:admin'], function () {
        // cetak laporan
        Route::get('/laporan', [LaporanController::class, 'laporan']);

        // Route Users
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::resource('users', UserController::class)->except(['destroy']);
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::put('/users/approve/{id}', [UserController::class, 'approve'])->name('users.approve');
        // Route::put('/users/reject/{id}', [UserController::class, 'reject'])->name('users.reject');

                


        // Route Categories
        Route::resource('categories', CategoryController::class);
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);

        // Route Lokasi
        Route::resource('lokasi', LocationController::class);

        // Route Aset
        Route::resource('aset', AsetController::class);
        Route::get('/get-nama-barang/{kode_id}', [AsetController::class, 'getNamaBarang']);
    });
});

// Route LoginRegister
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');
