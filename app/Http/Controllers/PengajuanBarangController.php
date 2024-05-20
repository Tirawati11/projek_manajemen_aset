<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\PengajuanBarang;
use Illuminate\Support\Facades\Auth;

class PengajuanBarangController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanBarang::where('user_id', Auth::id(), 'categories')->latest()->paginate(1);
        return view('pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        // Mendapatkan semua barang untuk ditampilkan di form pengajuan
        $category= Categories::all();
        return view('pengajuan.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        PengajuanBarang::create([
            'user_id' => Auth::id(),
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'status' => 'pending',
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function show($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        return view('pengajuan.show', compact('pengajuan'));
    }

    // form edit
    public function edit($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        $category= Categories::all();
        return view('pengajuan.edit', compact('pengajuan', compact('category')));
    }

     // Update pengajuan
     public function update(Request $request, $id)
     {
         $pengajuan = PengajuanBarang::findOrFail($id);
     
         $request->validate([
             'nama_barang' => 'required',
             'jumlah' => 'required|integer|min:1',
             'status' => 'required', 
         ]);
     
         $pengajuan->update([
             'nama_barang' => $request->nama_barang,
             'jumlah' => $request->jumlah,
             'status' => $request->status,
         ]);
     
         return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui.');
     } 

    //  Menghapus pengajuan
    public function destroy($id)
    {
        $pengajuan= PengajuanBarang::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
