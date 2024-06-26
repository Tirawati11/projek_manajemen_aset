<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\PengajuanBarang;
use Illuminate\Support\Facades\Auth;


class PengajuanBarangController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $query = PengajuanBarang::query()
            ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama_barang', 'LIKE', "%{$search}%")
                      ->orWhere('nama_pemohon', 'LIKE', "%{$search}%");
            });
        });

    // Dapatkan hasil paginasi
    $pengajuan = $query->latest()->paginate(5);

    // Sertakan query pencarian dalam hasil pagination
    $pengajuan->appends(['search' => $search]);

    return view('pengajuan.index', compact('pengajuan', 'search'));
}
    public function create()
    {
        // Mendapatkan semua barang untuk ditampilkan di form pengajuan
        // $category= Categories::all();
        return view('pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        PengajuanBarang::create([
            'nama_pemohon' => $request->nama_pemohon,
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
        // $category= Categories::all();
        return view('pengajuan.edit', compact('pengajuan'));
    }

     // Update pengajuan
     public function update(Request $request, $id)
     {
         // Temukan item pengajuan berdasarkan ID atau gagal
         $pengajuan = PengajuanBarang::findOrFail($id);

         // Validasi input
         $request->validate([
             'nama_barang' => 'required|string',
             'nama_pemohon' => 'required|string',
             'jumlah' => 'required|integer|min:1',
             'deskripsi' => 'required|string',
             'stok' => 'required|integer|min:0',
             'status' => 'required|string',
         ]);

         try {
             // Update item pengajuan
             $pengajuan->update([
                 'nama_barang' => $request->nama_barang,
                 'nama_pemohon' => $request->nama_pemohon,
                 'jumlah' => $request->jumlah,
                 'deskripsi' => $request->deskripsi,
                 'stok' => $request->stok,
                 'status' => $request->status,
             ]);

             // Redirect ke halaman index dengan pesan sukses
             return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui.');
         } catch (\Exception $e) {
             // Tangani kesalahan dan tampilkan pesan kesalahan
             return redirect()->back()->withErrors(['error' => $e->getMessage()]);
         }
     }

    //  Menghapus pengajuan
    public function destroy($id)
    {
        $pengajuan= PengajuanBarang::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
//   Aprove pengajuan
    public function approve($id)
{
    $pengajuan = PengajuanBarang::findOrFail($id);

    if ($pengajuan->status === 'pending') {
        $pengajuan->status = 'approved';
        $pengajuan->save();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }

    return redirect()->route('pengajuan.index')->with('error', 'Pengajuan tidak dapat disetujui.');
    }

    // Reject pengajuan barang
    public function reject($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);

        if ($pengajuan->status === 'pending') {
            $pengajuan->status = 'rejected';
            $pengajuan->save();

            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditolak.');
        }

        return redirect()->route('pengajuan.index')->with('error', 'Pengajuan tidak dapat ditolak.');
    }
}
