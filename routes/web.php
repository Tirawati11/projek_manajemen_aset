<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PengajuanBarangController;
use App\Http\Controllers\AuthController;


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


Route::resource('categories', CategoryController::class);
Route::get('/categories/{id}/edit', 'CategoryController@edit');
// Route pengajuan barang
Route::resource('pengajuan', PengajuanBarangController::class);
// Approved Pengajuan Barang
Route::post('/pengajuan/{id}/approve', [PengajuanBarangController::class, 'approve'])->name('pengajuan.approve');
Route::post('/pengajuan/{id}/reject', [PengajuanBarangController::class, 'reject'])->name('pengajuan.reject');



Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::delete('/logout', [AuthController::class, 'logout']);

Route::get('dashboard', function(){
    return 'hallo';
})->name('dashboard');


