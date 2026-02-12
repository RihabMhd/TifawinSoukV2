<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {

        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view(view: 'admin.categories.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);


        $validated['user_id'] = auth()->id();

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created with succes');
    }

    public function show(string $id)
    {

        $category = Category::with(['user', 'products.user'])->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(string $id)
    {

        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {

        $category = Category::findOrFail($id);


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);


        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated with  succes');
    }

    public function destroy(string $id)
    {

        $category = Category::findOrFail($id);


        if ($category->products()->count() > 0) {

            return redirect()->route('admin.categories.index')
                ->with('error', 'Cant delete category with existing products.');
        }


        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted with success');
    }
}
