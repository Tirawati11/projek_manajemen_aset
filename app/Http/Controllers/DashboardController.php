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
        
        $totalUsers = User::count();
        $totalAsets = Aset::count();
        $totalPengajuanBarang = PengajuanBarang::count();
        $totalPeminjamanBarang = PeminjamanBarang::count();
        $totalPengajuanBelumDisetujui = PengajuanBarang::where('status', 'pending')->count();

        return view('layouts.dashboard.index', compact('totalUsers', 'totalAsets', 'totalPengajuanBarang', 'totalPeminjamanBarang', 'totalPengajuanBelumDisetujui'));
    }
}
