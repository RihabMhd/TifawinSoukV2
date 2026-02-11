<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        if (auth()->check() && auth()->user()->isAdmin()) {
            return view('admin.products.index', compact('products', 'categories'));
        }

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('title')->get();
        $fournisseurs = Fournisseur::orderBy('name')->get();

        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')
                ->with('error', 'Please create a category first before adding products.');
        }

        return view('admin.products.create', compact('categories', 'fournisseurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0|max:999999.99',
            'quantity' => 'required|integer|min:0',
            'stock_alert_threshold' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['user_id'] = auth()->id();

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(string $id)
    {
        $product = Product::with(['user', 'category', 'fournisseur'])->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        if (auth()->check() && auth()->user()->isAdmin()) {
            return view('admin.products.show', compact('product', 'relatedProducts'));
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('title')->get();
        $fournisseurs = Fournisseur::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'fournisseurs'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0|max:999999.99',
            'quantity' => 'required|integer|min:0',
            'stock_alert_threshold' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
