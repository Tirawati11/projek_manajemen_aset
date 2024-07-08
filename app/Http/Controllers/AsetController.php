<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\Datatables;


class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Aset::with('category');

        // Ambil query pencarian dari request
        $search = $request->input('search.value');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode', 'like', '%' . $search . '%')
                    ->orWhere('nama_barang', 'like', '%' . $search . '%')
                    ->orWhere('merek', 'like', '%' . $search . '%')
                    ->orWhereRaw('DATE_FORMAT(tanggal_masuk, "%d-%m-%Y") like ?', ['%' . $search . '%'])
                    ->orWhereRaw('DATE_FORMAT(tanggal_masuk, "%m-%Y") like ?', ['%' . $search . '%'])
                    ->orWhereRaw('DATE_FORMAT(tanggal_masuk, "%Y") like ?', ['%' . $search . '%']);
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('category_name', function ($aset) {
                return $aset->category->name;
            })
            ->addColumn('gambar', function ($aset) {
                return '<img src="'. asset('/storage/aset/'.$aset->gambar) .'" class="rounded" style="width: 150px">';
            })
            ->editColumn('harga', function($row) {
                return 'Rp ' . number_format($row->harga, 2, ',', '.');
            })
            ->editColumn('tanggal_masuk', function($row) {
                return \Carbon\Carbon::parse($row->tanggal_masuk)->format('d-m-Y');
            })
            ->addColumn('action', function ($aset) {
                return '
                    <a href="'. route('aset.show', $aset->id) .'" class="btn btn-sm btn-dark" title="Show">
                        <i class="far fa-eye"></i>
                    </a>
                    <a href="'. route('aset.edit', $aset->id) .'" class="btn btn-sm btn-primary" title=" Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form id="delete-form-'. $aset->id .'" action="'. route('aset.destroy', $aset->id) .'" method="POST" class="d-inline delete-form">
                        '. csrf_field() .'
                        '. method_field('DELETE') .'
                        <button type="submit" class="btn btn-sm btn-danger delete-confirm" title=" Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }

    // Ambil data categories
    $categories = Category::all();

    return view('aset.index', compact('categories'));
}


    public function json()
    {
      return Datatables::of(Aset::limit(10))->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aset = null;
        $categories = Category::all();
        return view('aset.create', compact( 'aset','categories'));
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
            'deskripsi' => 'required',
            'merek' => 'required',
            'tanggal_masuk' => 'required|date',
            'kondisi' => 'required',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric',
        ]);

        // Upload image
        $image = $request->file('gambar');
        $image->storeAs('public/aset', $image->hashName());

        // Buat dan simpan data aset ke dalam database
        $aset = new Aset();
        $aset->gambar = $image->hashName();
        $aset->kode = $request->kode;
        $aset->nama_barang = $request->nama_barang;
        $aset->jumlah = $request->jumlah;
        $aset->deskripsi = $request->deskripsi;
        $aset->merek = $request->merek;
        $aset->tanggal_masuk = $request->tanggal_masuk; // Assign langsung dari request
        $aset->kondisi = $request->kondisi;
        $aset->harga = $request->harga;
        $aset->category_id = $request->category_id;
        $aset->save();

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $aset = Aset::findOrFail($id);
    $aset->harga_format = 'Rp ' . number_format($aset->harga, 2, ',', '.');
    return view('aset.show', compact('aset'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $aset = Aset::findOrFail($id);
        $categories = Category::all();
        return view('aset.edit', compact('aset', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'kode' => 'required|max:15',
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'deskripsi' => 'required',
            'merek' => 'required',
            'tanggal_masuk' => 'required|date',
            'kondisi' => 'required',
            'harga' => 'required|numeric',
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
        $aset->kode = $validated['kode'];
        $aset->nama_barang = $validated['nama_barang'];
        $aset->jumlah = $validated['jumlah'];
        $aset->deskripsi = $validated['deskripsi'];
        $aset->merek = $validated['merek'];
        $aset->tanggal_masuk = $validated['tanggal_masuk'];
        $aset->kondisi = $validated['kondisi'];
        $aset->category_id = $validated['category_id'];
        $aset->harga = $validated['harga'];
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
