<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class LaporanController extends Controller
{
    // public function laporan()
    // {
    //     // Ambil data dari model Aset
    //     $aset = Aset::all();

    //     // Lakukan perhitungan forecast jika diperlukan
    //     $forecasts = $this->calculateForecast($aset);

    //     // Kembalikan view dengan data
    //     return view('laporan', compact('aset', 'forecasts'));
    // }

    // private function calculateForecast($asets)
    // {
    //     // Contoh sederhana perhitungan forecast
    //     $forecasts = [];
    //     foreach ($asets as $aset) {
    //         $forecasts[$aset->id] = $aset->value * 1.1; // Contoh: forecast meningkat 10%
    //     }
    //     return $forecasts;
    // }
    public function laporan(Request $request)
    {
        // Ambil semua data dari model Aset
        $aset = Aset::query();

        // Filter berdasarkan bulan dan tahun jika ada permintaan
        if ($request->has('bulan') && $request->has('tahun')) {
            $aset->whereMonth('tanggal_masuk', $request->bulan)
                 ->whereYear('tanggal_masuk', $request->tahun);
        }

        $aset = $aset->get();

        // Lakukan perhitungan forecast jika diperlukan
        $forecasts = $this->calculateForecast($aset);

        // Kembalikan view dengan data
        return view('laporan', compact('aset', 'forecasts'));
    }

    public function calculateForecast($asets)
    {
    // Contoh sederhana perhitungan forecast
    $forecasts = [];
    foreach ($asets as $aset) {
        $forecasts[$aset->id] = $aset->value * 1.1;
    }
    return $forecasts;
}
}

