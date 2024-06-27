<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\PeminjamanBarang;
use App\Models\PengajuanBarang;

class LaporanController extends Controller
{
    public function laporanInventaris(Request $request)
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
        return view('laporan.inventaris', compact('aset', 'forecasts'));
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
// Laporan Peminjaman
public function laporanPeminjaman(Request $request)
{
    // Ambil semua data dari model Peminjaman
    $peminjamanQuery = PeminjamanBarang::with('barang');

    // Filter berdasarkan bulan dan tahun jika ada permintaan
    if ($request->has('bulan') && $request->has('tahun')) {
        $peminjamanQuery->whereMonth('tanggal_peminjaman', $request->bulan)
            ->whereYear('tanggal_peminjaman', $request->tahun);
    }

    $peminjaman = $peminjamanQuery->paginate(10);

    // Lakukan perhitungan forecast jika diperlukan (contoh dummy function)
    $forecasts = $this->calculateForecast($peminjaman);

    // Kembalikan view dengan data
    return view('laporan.peminjaman', compact('peminjaman', 'forecasts'));
}

public function calculate($peminjaman)
{
    // Contoh sederhana perhitungan forecast
    $forecasts = [];
    foreach ($peminjaman as $item) {
        $forecasts[$item->id] = $item->value * 1.1;
    }
    return $forecasts;
}
// Laporan Pengajuan
public function laporanPengajuan(Request $request)
    {
        // Ambil semua data dari model PengajuanBarang
        $pengajuanQuery = PengajuanBarang::query();

        // Filter berdasarkan nama pemohon jika ada dalam permintaan
        if ($request->has('nama_pemohon')) {
            $pengajuanQuery->where('nama_pemohon', 'like', '%' . $request->input('nama_pemohon') . '%');
        }

        // Filter berdasarkan status jika ada dalam permintaan
        if ($request->has('status')) {
            $status = $request->input('status');
            $pengajuanQuery->where('status', $status);
        }

        // Lakukan pengurutan data berdasarkan tanggal dibuat secara descending (terbaru dulu)
        $pengajuanQuery->orderBy('created_at', 'desc');

        // Ambil data dengan pagination
        $pengajuan = $pengajuanQuery->paginate(10);

        // Kembalikan view dengan data
        return view('laporan.pengajuan', compact('pengajuan'));
    }
    
    public function calculatePengajuan($pengajuan)
{
    // Contoh sederhana perhitungan forecast
    $forecasts = [];
    foreach ($pengajuan as $item) {
        $forecasts[$item->id] = $item->value * 1.1;
    }
    return $forecasts;
}
}

