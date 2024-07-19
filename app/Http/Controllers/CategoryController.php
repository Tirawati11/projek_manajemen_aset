<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Aset;


class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::paginate(10);
    return view('categories.index', compact('categories'));
}

public function create()
{
    return view('categories.create');
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->nama_kategori,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $asets = $category->asets;
        $asets = Aset::all(); // Asumsi bahwa relasi antara kategori dan aset adalah 'asets'
        return view('categories.show', compact('category', 'asets'));
    }
    
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
    
    public function update(Request $request, $id)
{
    $category = Category::find($id);
    $category->name = $request->nama_kategori; // Ensure the input name matches the form input name
    $category->save();

    return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
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
