<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;



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
        $category = Category::with('aset')->findOrFail($id);
        return response()->json(['category' => $category]);
    }


public function edit(Category $category)
{
    return view('categories.edit', compact('category'));
}

public function update(Request $request, Category $category)
{
    $request->validate([
        'nama_kategori' => 'required|string|max:255',
    ]);

    $category->name = $request->nama_kategori;
    $category->save();

    return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
}

public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->aset()->count() > 0) {
                return response()->json(['success' => false, 'message' => 'Kategori tidak bisa dihapus karena masih berelasi dengan aset.']);
            }

            $category->delete();

            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus kategori.']);
        }
    }
}
