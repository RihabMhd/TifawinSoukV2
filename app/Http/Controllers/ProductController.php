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
        // get all products and categories
        $products = Product::all();
        $categories = Category::all();

        // if user is admin, show admin view
        if (auth()->check() && auth()->user()->isAdmin()) {
            return view('admin.products.index', compact('products', 'categories'));
        }

        // if normal user, show normal view
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        // get categories and suppliers sorted by name
        $categories = Category::orderBy('title')->get();
        $fournisseurs = Fournisseur::orderBy('name')->get();

        // if no categories exist, redirect to create category first
        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')
                ->with('error', 'Please create a category first before adding products.');
        }

        return view('admin.products.create', compact('categories', 'fournisseurs'));
    }

    public function store(Request $request)
    {
        // check if all data is valid
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

        // if user upload image
        if ($request->hasFile('image')) {
            // save image in storage/app/public/products folder
            $imagePath = $request->file('image')->store('products', 'public');
            // add image path to validated data
            $validated['image'] = $imagePath;
        }

        // add user id of who created product
        $validated['user_id'] = auth()->id();

        // create product in database
        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(string $id)
    {
        // get product with user, category and supplier relations
        $product = Product::with(['user', 'category', 'fournisseur'])->findOrFail($id);

        // get 4 similar products from same category (but not this product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // if admin, show admin view
        if (auth()->check() && auth()->user()->isAdmin()) {
            return view('admin.products.show', compact('product', 'relatedProducts'));
        }

        // if normal user, show normal view
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function edit(string $id)
    {
        // find product
        $product = Product::findOrFail($id);
        // get all categories and suppliers
        $categories = Category::orderBy('title')->get();
        $fournisseurs = Fournisseur::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'fournisseurs'));
    }

    public function update(Request $request, string $id)
    {
        // find product or 404
        $product = Product::findOrFail($id);

        // check if new data is valid
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

        // if user upload new image
        if ($request->hasFile('image')) {
            // delete old image if exist
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // save new image
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // update product with ew data
        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(string $id)
    {
        // find product or 404
        $product = Product::findOrFail($id);

        // if product have image, delete it from storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // delete product from database
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}