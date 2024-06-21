<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBarang;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Barang;
use Carbon\Carbon;

class PeminjamanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query data peminjaman berdasarkan pencarian
        $query = PeminjamanBarang::with('location', 'barang')->latest();
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama_barang_id', 'LIKE', "%$search%")
                      ->orWhere('nama', 'LIKE', "%$search%"); 
            });
        }

        // Menggunakan paginate dengan 5 item per halaman
        $peminjaman = $query->paginate(5);

        // Manipulasi tanggal menggunakan Carbon
        foreach ($peminjaman as $item) {
            $item->tanggal_peminjaman = Carbon::parse($item->tanggal_peminjaman)->format('d-m-Y');
            $item->tanggal_pengembalian = $item->tanggal_pengembalian ? Carbon::parse($item->tanggal_pengembalian)->format('d-m-Y') : null;
        }

        return view('peminjaman.index', compact('peminjaman', 'search'));
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
        'nama' => 'required|string',
        'nama_barang_id' => 'required|exists:barangs,id',
        'jumlah' => 'required|integer|min:1',
        'location_id' => 'required|exists:locations,id',
        'tanggal_peminjaman' => 'required|date',
        'tanggal_pengembalian' => 'nullable|date|after:tanggal_peminjaman',
        'status' => 'required|in:dipinjam,kembali',
    ]);

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
    $peminjaman = PeminjamanBarang::findOrFail($id);

    // Ubah format tanggal menggunakan Carbon
    $peminjaman->tanggal_peminjaman = Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y');
    $peminjaman->tanggal_pengembalian = $peminjaman->tanggal_pengembalian ? Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y') : null;

    $location = Location::all();
    $barang = Barang::all();
    return view('peminjaman.show', compact('peminjaman', 'location', 'barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeminjamanBarang $peminjaman)
    {
        $locations = Location::select('id', 'name')->get();
        $barangs = Barang::all();
        return view('peminjaman.edit', compact('peminjaman', 'locations', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PeminjamanBarang $peminjaman)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'nama_barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'location_id' => 'required|exists:locations,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date|after:tanggal_peminjaman',
            'status' => 'required|in:dipinjam,kembali',
        ]);

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
