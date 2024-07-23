<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Aset;
use Yajra\DataTables\Facades\Datatables;




class CategoryController extends Controller
{
    public function index()
{
    // Mengambil data kategori
    $categories = Category::select(['id', 'name']);

    // Jika request adalah AJAX untuk DataTables
    if (request()->ajax()) {
        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="#" class="btn btn-sm btn-dark btn-show" data-id="' . $row->id . '" title="Show">
                            <i class="far fa-eye"></i>
                        </a>';
                $btn .= '<form action="' . route('categories.destroy', $row->id) . '" method="POST" class="d-inline form-delete">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Jika request adalah GET biasa untuk menampilkan halaman
    return view('categories.index');
}

public function create()
{
    return view('categories.create');
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->nama_kategori,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Mengambil data kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Mengambil data aset yang terkait dengan kategori tersebut
        $asets = $category->aset
        ;

        return view('categories.show', compact('category', 'asets'));
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category
        ]);
    }


    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan.']);
        }

        // Misalkan kategori berelasi dengan produk, menggunakan relasi hasMany bernama 'products'
        if ($category->aset()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Kategori masih berelasi dengan produk dan tidak bisa dihapus.']);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Kategori telah dihapus.']);
    }
}