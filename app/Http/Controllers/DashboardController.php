<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\User;
use App\Models\PengajuanBarang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $totalAsets = Aset::count();
        $totalUsers = User::count();
        $totalPengajuanBarang = PengajuanBarang::count();

        return view('layouts.dashboard.index', compact( 'totalAsets', 'totalUsers','totalPengajuanBarang'));
    }
}
