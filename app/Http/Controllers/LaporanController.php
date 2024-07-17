<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\PeminjamanBarang;
use App\Models\PengajuanBarang;
use Yajra\DataTables\Facades\Datatables;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function laporanAset(Request $request)
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
        return view('laporan.aset', compact('aset', 'forecasts'));
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
    if ($request->ajax()) {
        $peminjamanQuery = PeminjamanBarang::with('barang');

        if ($request->has('bulan') && $request->has('tahun')) {
            $peminjamanQuery->whereMonth('tanggal_peminjaman', $request->bulan)
                ->whereYear('tanggal_peminjaman', $request->tahun);
        }

        return DataTables::eloquent($peminjamanQuery)
            ->addIndexColumn()
            ->addColumn('nama_barang', function ($peminjaman) {
                return $peminjaman->barang->nama_barang;
            })
            ->editColumn('tanggal_peminjaman', function ($peminjaman) {
                return Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y');
            })
            ->editColumn('tanggal_pengembalian', function ($peminjaman) {
                return Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y');
            })
            ->rawColumns(['tanggal_peminjaman', 'tanggal_pengembalian'])
            ->make(true);
    }

    return view('laporan.peminjaman');
}

    public function calculate($peminjaman)
    {
    $forecasts = [];
    foreach ($peminjaman as $item) {
        $forecasts[$item->id] = $item->value * 1.1;
    }
    return $forecasts;
    }

    // Laporan Pengajuan
    public function laporanPengajuan(Request $request)
    {
        if ($request->ajax()) {
            $pengajuanQuery = PengajuanBarang::query();

            // Filter by nama_pemohon
            if ($request->has('nama_pemohon') && !empty($request->input('nama_pemohon'))) {
                $pengajuanQuery->where('nama_pemohon', 'like', '%' . $request->input('nama_pemohon') . '%');
            }

            // Filter by status
            if ($request->has('status') && !empty($request->input('status'))) {
                $pengajuanQuery->where('status', $request->input('status'));
            }

            // Order data
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');
            $orderColumn = $request->input('columns.' . $orderColumnIndex . '.data');

            // Validate order column
            if ($orderColumnIndex !== null && $orderDirection !== null && in_array($orderColumn, ['nama_barang', 'nama_pemohon', 'status', 'created_at'])) {
                $pengajuanQuery->orderBy($orderColumn, $orderDirection);
            } else {
                $pengajuanQuery->orderBy('created_at', 'desc'); // Default order if not provided
            }

            return DataTables::eloquent($pengajuanQuery)
                ->addIndexColumn()
                ->editColumn('status', function ($item) {
                    $badgeClass = $item->status === 'pending' ? 'badge badge-warning' : ($item->status === 'approved' ? 'badge badge-success' : ($item->status === 'rejected' ? 'badge badge-danger' : ''));
                    return '<span class="' . $badgeClass . '">' . $item->status . '</span>';
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('laporan.pengajuan');
    }
}

