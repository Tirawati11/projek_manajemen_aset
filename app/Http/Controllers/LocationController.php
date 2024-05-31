<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\PeminjamanBarang;


class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $search = $request->input('search');

    // Query data lokasi berdasarkan pencarian
    $query = Location::query();
    if ($search) {
        $query->where('name', 'LIKE', "%$search%");
    }

    // Menggunakan paginate dengan 10 item per halaman
    $locations = $query->paginate(5);

    return view('lokasi.index', compact('locations', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:locations,name',
        ]);

        Location::create($validatedData);

        return redirect()->route('lokasi.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return view('lokasi.show', compact('location'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::find($id);
        return view('lokasi.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            // Cari lokasi berdasarkan ID
            $location = Location::findOrFail($id);

            // Update data lokasi
            $location->update($validatedData);

            // Jika permintaan berasal dari AJAX, kembalikan respons JSON
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Lokasi berhasil diperbarui!',
                    'data' => $location
                ], 200);
            }

            // Jika bukan AJAX, arahkan kembali dengan pesan sukses
            return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil diperbarui!');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons JSON jika permintaan AJAX
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat memperbarui lokasi!',
                    'error' => $e->getMessage()
                ], 500);
            }

            // Jika bukan AJAX, arahkan kembali dengan pesan error
            return redirect()->route('lokasi.index')->with('error', 'Terjadi kesalahan saat memperbarui lokasi!');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        if ($location) {
            $location->delete();
            return redirect()->route('lokasi.index')->with('success', 'Lokasi telah dihapus.');
        } else {
            return redirect()->route('lokasi.index')->with('error', 'Lokasi tidak ditemukan.');
        }
    }
}
