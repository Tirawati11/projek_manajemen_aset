<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aset = Aset::latest()->paginate(10);
        return view('aset.index', compact('aset'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aset.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'kode' => 'required|max:15',
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'status' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'merek' => 'required',
            'tahun' => 'required',
            'kondisi' => 'required',
        ]);

        // Simpan gambar ke dalam direktori 'public/gambar'
        $gambarPath = $request->file('gambar')->store('public/gambar');

        // Buat dan simpan data aset ke dalam database
        $aset = new Aset();
        $aset->gambar = $gambarPath;  // Simpan path gambar ke dalam kolom 'gambar'
        $aset->kode = $request->kode;
        $aset->nama_barang = $request->nama_barang;
        $aset->jumlah = $request->jumlah;
        $aset->status = $request->status;
        $aset->deskripsi = $request->deskripsi;
        $aset->lokasi = $request->lokasi;
        $aset->merek = $request->merek;
        $aset->tahun = $request->tahun;
        $aset->kondisi = $request->kondisi;
        $aset->save();

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aset $aset)
    {
        return view('aset.show', compact('aset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aset $aset)
    {
        return view('aset.edit', compact('aset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aset $aset)
    {
        $validated = $request->validate([
            'gambar' => 'image|mimes:jpeg,jpg,png|max:2048',
            'kode' => 'required|max:15',
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'status' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'merek' => 'required',
            'tahun' => 'required',
            'kondisi' => 'required',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            Storage::delete($aset->gambar);

            // Simpan gambar baru ke dalam direktori 'public/gambar'
            $gambarPath = $request->file('gambar')->store('public/gambar');
            $aset->gambar = $gambarPath;  // Simpan path gambar ke dalam kolom 'gambar'
        }

        $aset->kode = $request->kode;
        $aset->nama_barang = $request->nama_barang;
        $aset->jumlah = $request->jumlah;
        $aset->status = $request->status;
        $aset->deskripsi = $request->deskripsi;
        $aset->lokasi = $request->lokasi;
        $aset->merek = $request->merek;
        $aset->tahun = $request->tahun;
        $aset->kondisi = $request->kondisi;
        $aset->save();

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aset $aset)
    {
        // Hapus gambar terkait dari storage
        Storage::delete($aset->gambar);

        // Hapus data aset dari database
        $aset->delete();

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil dihapus.');
    }
}
