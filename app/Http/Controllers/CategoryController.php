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
        'name' => 'required',
    ]);

    Category::create($request->all());
    return redirect()->route('categories.index');
}

public function show(Category $category)
{
    return view('categories.show', compact('category'));
}

public function edit(Category $category)
{
    return view('categories.edit', compact('category'));
}

public function update(Request $request, Category $category)
{
    $category->update($request->all());
    return redirect()->route('categories.index');
}

public function destroy(Category $category)
{
    $category->delete();
    return redirect()->route('categories.index');
}
}