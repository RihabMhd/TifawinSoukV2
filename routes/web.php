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
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;

require __DIR__ . '/auth.php';

// Public Routes
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->middleware('verified')->name('user.dashboard');

    // Cart Routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{product}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });


    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Order Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'cancel'])->name('orders.cancel');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Products 
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // Fournisseurs 
    Route::prefix('fournisseurs')->name('fournisseurs.')->group(function () {
        Route::get('/', [FournisseurController::class, 'index'])->name('index');
        Route::get('/create', [FournisseurController::class, 'create'])->name('create');
        Route::post('/', [FournisseurController::class, 'store'])->name('store');
        Route::get('/archive', [FournisseurController::class, 'archive'])->name('archive');
        Route::get('/edit/{id}', [FournisseurController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [FournisseurController::class, 'update'])->name('update');
        Route::delete('/{id}', [FournisseurController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/trash', [FournisseurController::class, 'trash'])->name('trash');
        Route::post('/{id}/restore', [FournisseurController::class, 'restore'])->name('restore');
    });

    // Stock Management
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/dashboard', [StockController::class, 'dashboard'])->name('dashboard');
        Route::get('/adjust/{id}', [StockController::class, 'edit'])->name('edit');
        Route::patch('/adjust/{product}', [StockController::class, 'adjust'])->name('adjust');
    });
});
