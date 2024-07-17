<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBarang;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Log;


class PeminjamanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         if ($request->ajax()) {
             $peminjamanQuery = PeminjamanBarang::with('barang');

             if ($request->has('tanggal_peminjaman') && !empty($request->tanggal_peminjaman)) {
                 $tanggal_peminjaman = $request->tanggal_peminjaman;
                 if (preg_match('/^\d{4}$/', $tanggal_peminjaman)) {
                    $peminjamanQuery->whereYear('tanggal_peminjaman', $tanggal_peminjaman);
                 } elseif (preg_match('/^\d{2}-\d{4}$/', $tanggal_peminjaman)) {
                    [$bulan, $tahun] = explode('-', $tanggal_peminjaman);
                     $peminjamanQuery->whereMonth('tanggal_peminjaman', $bulan)
                                     ->whereYear('tanggal_peminjaman', $tahun);
                 } else {
                    $parts = explode('-', $tanggal_peminjaman);
                     $tanggal_peminjaman = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                     $peminjamanQuery->whereDate('tanggal_peminjaman', $tanggal_peminjaman);
                 }
             }

             // Filter berdasarkan tanggal pengembalian
             if ($request->has('tanggal_pengembalian') && !empty($request->tanggal_pengembalian)) {
                 $tanggal_pengembalian = $request->tanggal_pengembalian;
                 if (preg_match('/^\d{4}$/', $tanggal_pengembalian)) {
                $peminjamanQuery->whereYear('tanggal_pengembalian', $tanggal_pengembalian);
                 } elseif (preg_match('/^\d{2}-\d{4}$/', $tanggal_pengembalian)) {
                     [$bulan, $tahun] = explode('-', $tanggal_pengembalian);
                     $peminjamanQuery->whereMonth('tanggal_pengembalian', $bulan)
                                     ->whereYear('tanggal_pengembalian', $tahun);
                 } else {
                    $parts = explode('-', $tanggal_pengembalian);
                     $tanggal_pengembalian = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                     $peminjamanQuery->whereDate('tanggal_pengembalian', $tanggal_pengembalian);
                 }
             }

             return DataTables::eloquent($peminjamanQuery)
                 ->addIndexColumn()
                 ->addColumn('nama_barang', function ($peminjaman) {
                     return $peminjaman->barang ? $peminjaman->barang->nama_barang : 'Barang tidak tersedia';
                 })
                 ->addColumn('action', function ($peminjaman) {
                     $btn = '<a href="'.route('peminjaman.show', $peminjaman->id).'" class="btn btn-sm btn-dark" title="show">
                     <i class="far fa-eye"></i>
                     </a>';
                     $btn .= ' <a href="'.route('peminjaman.edit', $peminjaman->id).'" class="btn btn-sm btn-primary" title="Edit">
                     <i class="fas fa-edit"></i>
                     </a>';
                     $btn .= '<form action="'.route('peminjaman.destroy', $peminjaman->id).'" method="POST" class="d-inline">
                                 '.csrf_field().'
                                 '.method_field("DELETE").'
                                 <button type="submit" title="Hapus" class="btn btn-sm btn-danger delete-confirm"><i class="fas fa-trash-alt"></i></button>
                              </form>';
                     return $btn;
                 })
                 ->editColumn('tanggal_peminjaman', function ($peminjaman) {
                     return Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y');
                 })
                 ->editColumn('tanggal_pengembalian', function ($peminjaman) {
                     return Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y');
                 })
                 ->rawColumns(['tanggal_peminjaman', 'tanggal_pengembalian', 'action'])
                 ->make(true);
         }

         return view('peminjaman.index');
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $locations = Location::select('id', 'name')->get();
    $barangs = Barang::all();
    return view('peminjaman.create', compact('locations', 'barangs'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nama_barang_id' => 'required|exists:barangs,id',
        'jumlah' => 'required|integer|min:1',
        'location_id' => 'required|exists:locations,id',
        'tanggal_peminjaman' => 'required|date',
        'tanggal_pengembalian' => 'nullable|date|after:tanggal_peminjaman',
        'status' => 'required|in:dipinjam,kembali',
    ]);

     // Tambahkan user_id dari pengguna yang sedang login
     $validatedData['nama_peminjam'] = Auth::user()->nama_user;

    // Simpan data ke database
    PeminjamanBarang::create($validatedData);
    return redirect()->route('peminjaman.index')
        ->with('success', 'Peminjaman barang berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $peminjaman = PeminjamanBarang::with(['user', 'barang', 'location'])->findOrFail($id);

        // Ubah format tanggal menggunakan Carbon
        $peminjaman->tanggal_peminjaman = Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y');
        $peminjaman->tanggal_pengembalian = $peminjaman->tanggal_pengembalian ? Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y') : null;

        return view('peminjaman.show', compact('peminjaman'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeminjamanBarang $peminjaman)
    {
        $locations = Location::select('id', 'name')->get();
        $barangs = Barang::all();
        $user = Auth::user();
        return view('peminjaman.edit', compact('peminjaman', 'locations', 'barangs', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PeminjamanBarang $peminjaman)
    {
        $validatedData = $request->validate([
            'nama_barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'location_id' => 'required|exists:locations,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date|after:tanggal_peminjaman',
            'status' => 'required|in:dipinjam,kembali',
        ]);
          // Tambahkan user_id dari pengguna yang sedang login
        $validatedData['user_id'] = Auth::id();

        $peminjaman->update($validatedData);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
   {
       $peminjamanBarang = PeminjamanBarang::findOrFail($id);
       $peminjamanBarang->delete();

       return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
   }
}
