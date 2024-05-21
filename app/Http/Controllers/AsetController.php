<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Year;
use App\Models\Code;
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

        // Query untuk mendapatkan data aset dengan pencarian
        $query = Aset::with('years', 'codes');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('merek', 'like', '%' . $search . '%')
                  ->orWhereHas('years', function($q) use ($search) {
                      $q->where('tahun', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('codes', function($q) use ($search) {
                      $q->where('kode', 'like', '%' . $search . '%');
                  });
            });
        }

        // Dapatkan hasil paginasi
        $asets = $query->latest()->paginate(1);

        // Sertakan query pencarian dalam hasil pagination
        $asets->appends(['search' => $search]);

        // Ambil data years dan codes
        $years = Year::all();
        $codes = Code::all();

        return view('aset.index', compact('asets', 'years', 'codes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $years = Year::all();
        $codes = Code::all();
        return view('aset.create', compact('years', 'codes'));
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
            'year_id' => 'required', // Ubah ini sesuai dengan nama field foreign key yang digunakan dalam model Aset
            'kondisi' => 'required',
        ]);

       //upload image
       $image = $request->file( 'gambar' );
       $image->storeAs( 'public/aset', $image->hashName() );


        // Buat dan simpan data aset ke dalam database
        $aset = new Aset();
        $aset->gambar = $image->hashName();  // Simpan path gambar ke dalam kolom 'gambar'
        $aset->code_id = $request->code_id;
        $aset->nama_barang = $request->nama_barang;
        $aset->jumlah = $request->jumlah;
        $aset->deskripsi = $request->deskripsi;
        $aset->merek = $request->merek;
        $aset->year_id = $request->year_id; // Sesuaikan dengan nama field foreign key yang digunakan dalam model Aset
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
    public function edit(string $id)
    {
        $aset = Aset::findOrFail($id);
        $years = Year::all();
        $codes = Code::all();
        return view('aset.edit', compact('aset', 'years', 'codes'));
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
        'year_id' => 'required', // Ubah ini sesuai dengan nama field foreign key yang digunakan dalam model Aset
        'kondisi' => 'required',
    ]);

    $aset = Aset::findOrFail($id);
    // Jika ada file gambar yang diunggah
    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar');
        $imageName = $gambar->getClientOriginalName();
        $gambar->storeAs('public/article', $imageName);

        // Hapus gambar lama dari storage
        Storage::delete('public/article/'.$aset->gambar);


        // Upload gambar baru
        $image = $request->file('gambar');
        $image->storeAs('public/aset', $image->hashName());
        $aset->gambar = $image->hashName();  // Simpan path gambar baru ke dalam kolom 'gambar'
    }

    // Update data aset
    $aset->code_id = $request->code_id;
    $aset->nama_barang = $request->nama_barang;
    $aset->jumlah = $request->jumlah;
    $aset->deskripsi = $request->deskripsi;
    $aset->merek = $request->merek;
    $aset->year_id = $request->year_id;
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
