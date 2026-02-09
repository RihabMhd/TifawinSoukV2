<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\admin\StockController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

require __DIR__ . '/auth.php';

// Public routes
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');
    
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Client orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Admin dashboard - MUST call the controller method
    Route::get('/dashboard', [AdminOrderController::class, 'dashboard'])->name('admin.dashboard');
    
    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Products
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    
    // Fournisseurs
    Route::get('/fournisseurs', [FournisseurController::class, 'index'])->name('admin.fournisseurs.index');
    Route::get('/fournisseurs/create', [FournisseurController::class, 'create'])->name('admin.fournisseurs.create');
    Route::get('/fournisseurs/archive', [FournisseurController::class, 'archive'])->name('admin.fournisseurs.archive');
    Route::post('/fournisseurs', [FournisseurController::class, 'store'])->name('admin.fournisseurs.store');
    Route::get('/fournisseurs/edit/{id}', [FournisseurController::class, 'edit'])->name('admin.fournisseurs.edit');
    Route::put('/fournisseurs/{id}/update', [FournisseurController::class, 'update'])->name('admin.fournisseurs.update');
    Route::delete('/fournisseurs/{id}', [FournisseurController::class, 'destroy'])->name('admin.fournisseurs.destroy');
    Route::delete('/fournisseurs/{id}/trash', [FournisseurController::class, 'trash'])->name('admin.fournisseurs.trash');
    Route::post('/fournisseurs/{id}/restore', [FournisseurController::class, 'restore'])->name('admin.fournisseurs.restore');
    
    // Admin Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'cancel'])->name('admin.orders.cancel');
    
    // Stock
    Route::get('/stock/dashboard', [StockController::class, 'dashboard'])->name('admin.stock.dashboard');
});