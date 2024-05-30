<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Category;
use App\Models\Code;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil query pencarian dari request
        $search = $request->input('search');
        $dateSearch = $request->input('date_search');
    
        // Query untuk mendapatkan data aset dengan pencarian
        $query = Aset::with('codes', 'category');
    
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('merek', 'like', '%' . $search . '%')
                  ->orWhereHas('codes', function($q) use ($search) {
                      $q->where('kode', 'like', '%' . $search . '%');
                  });
            });
        }
    
        // Tambahkan pencarian berdasarkan tanggal_masuk
        if ($dateSearch) {
            try {
                $date = Carbon::createFromFormat('d-m-Y', $dateSearch);
                $query->whereDate('tanggal_masuk', $date);
            } catch (\Exception $e) {
                // Handle exception jika format tanggal tidak valid
            }
        }
    
        // Dapatkan hasil paginasi
        $asets = $query->latest()->paginate(5);
    
        // Sertakan query pencarian dalam hasil pagination
        $asets->appends(['search' => $search, 'date_search' => $dateSearch]);
    
        // Ambil data codes dan categories
        $codes = Code::all();
        $categories = Category::all();
    
        return view('aset.index', compact('asets', 'codes', 'search', 'categories', 'dateSearch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aset = null; 
        $codes = Code::all();
        $categories = Category::all();
        return view('aset.create', compact( 'aset','codes', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'code_id' => 'required|max:15',
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'deskripsi' => 'required',
            'merek' => 'required',
            'tanggal_masuk' => 'required|date',
            'kondisi' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        // Upload image
        $image = $request->file('gambar');
        $image->storeAs('public/aset', $image->hashName());
    
        // Buat dan simpan data aset ke dalam database
        $aset = new Aset();
        $aset->gambar = $image->hashName();
        $aset->code_id = $request->code_id;
        $aset->nama_barang = $request->nama_barang;
        $aset->jumlah = $request->jumlah;
        $aset->deskripsi = $request->deskripsi;
        $aset->merek = $request->merek;
        $aset->tanggal_masuk = $request->tanggal_masuk; // Assign langsung dari request
        $aset->kondisi = $request->kondisi;
        $aset->category_id = $request->category_id;
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
    public function edit(string $id)
    {
        $aset = Aset::findOrFail($id);
        $codes = Code::all();
        $categories = Category::all();
        return view('aset.edit', compact('aset','codes', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'code_id' => 'required|max:15',
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'deskripsi' => 'required',
            'merek' => 'required',
            'tanggal_masuk' => 'required|date',
            'kondisi' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $aset = Aset::findOrFail($id);
    
        // Jika ada file gambar yang diunggah
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $imageName = $gambar->hashName(); // Menggunakan hashName() untuk mendapatkan nama file unik
            $gambar->storeAs('public/aset', $imageName);
    
            // Hapus gambar lama dari storage jika ada
            if ($aset->gambar) {
                Storage::delete('public/aset/' . $aset->gambar);
            }
    
            // Simpan path gambar baru ke dalam kolom 'gambar'
            $aset->gambar = $imageName;
        }
    
        // Update data aset
        $aset->code_id = $validated['code_id'];
        $aset->nama_barang = $validated['nama_barang'];
        $aset->jumlah = $validated['jumlah'];
        $aset->deskripsi = $validated['deskripsi'];
        $aset->merek = $validated['merek'];
        $aset->tanggal_masuk = $validated['tanggal_masuk'];
        $aset->kondisi = $validated['kondisi'];
        $aset->category_id = $validated['category_id'];
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
    public function getNamaBarang($kode_id)
    {
        // Cari nama barang berdasarkan kode yang diberikan
        $nama_barang = Item::where('code_id', $kode_id)->value('nama_barang');

        // Pastikan nama barang ditemukan
        if ($nama_barang) {
            return response()->json(['nama_barang' => $nama_barang]);
        } else {
            // Jika nama barang tidak ditemukan, kirim respons error
            return response()->json(['error' => 'Nama barang tidak ditemukan'], 404);
        }
    }
}
