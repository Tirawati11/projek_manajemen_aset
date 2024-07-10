<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;



class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select(['id', 'name']);

            return DataTables::of($categories)
                ->addColumn('action', function($category) {
                    return '
                        <a href="#" class="btn btn-sm btn-dark btn-show" data-id="'.$category->id.'" data-name="'.$category->name.'"><i class="far fa-eye" title="Show"></i></a>
                        <a href="#" class="btn btn-sm btn-primary btn-edit" data-id="'.$category->id.'" data-name="'.$category->name.'"><i class="fas fa-edit" title="Edit"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="'.$category->id.'"><i class="fas fa-trash-alt" title="Hapus"></i></button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('categories.index');
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
        $asets = $category->aset; // Pastikan relasi 'assets' sudah didefinisikan di model Category

        return view('categories.show', compact('category', 'asets'));
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
        $category = Category::find($id);
        $category = Category::findOrFail($id);
        $category->delete();
    
        // Set flash message
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    
    }
}