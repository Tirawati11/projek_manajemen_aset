<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\User;
use App\Models\PengajuanBarang;
use App\Models\PeminjamanBarang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class DashboardController extends Controller
{
    public function index()
    {
        
        $totalAsets = Aset::count();
        $totalUsers = User::count();
        $totalPengajuanBarang = PengajuanBarang::count();
        $totalPeminjamanBarang = PeminjamanBarang::count();


        return view('layouts.dashboard.index', compact( 'totalAsets', 'totalUsers','totalPengajuanBarang', 'totalPeminjamanBarang'));
    }
}
