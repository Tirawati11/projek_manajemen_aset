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
        if(request()->ajax()) {
            $categories = Category::select('*');
            return Datatables::of($categories)
                ->addColumn('action', function($category){
                    $editUrl = route('categories.edit', $category->id);
                    $deleteUrl = route('categories.destroy', $category->id);
                    return '<a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                            <form action="'.$deleteUrl.'" method="POST" class="d-inline">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('categories.index');
    }
    
    public function json()
    {
      return Datatables::of(category::limit(10))->make(true);
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