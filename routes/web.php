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

// Public Routes
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->middleware('verified')->name('user.dashboard');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // PayPal Specific Routes
    Route::get('/paypal/success/{order}', [CheckoutController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/paypal/cancel/{order}', [CheckoutController::class, 'paypalCancel'])->name('paypal.cancel');

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
Route::middleware(['auth', 'admin'])->group(function () {
    // Categories
    Route::resource('categories', CategoryController::class);

    // Orders (Admin)
    Route::put('/admin/orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');

    // Products (Admin)
    Route::get('/admin/products/{id}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Fournisseurs (Suppliers)
    Route::get('/admin/fournisseurs/create', [FournisseurController::class, 'create'])->name('admin.fournisseurs.create');
    Route::get('/admin/fournisseurs/archive', [FournisseurController::class, 'archive'])->name('admin.fournisseurs.archive');
    Route::post('/admin/fournisseurs', [FournisseurController::class, 'store'])->name('admin.fournisseurs.store');
    Route::get('/admin/fournisseurs/edit/{id}', [FournisseurController::class, 'edit'])->name('admin.fournisseurs.edit');
    Route::put('/admin/fournisseurs/{id}/update', [FournisseurController::class, 'update'])->name('admin.fournisseurs.update');
    Route::get('/admin/fournisseurs', [FournisseurController::class, 'index'])->name('admin.fournisseurs.index');
    Route::delete('/admin/fournisseurs/{id}', [FournisseurController::class, 'destroy'])->name('admin.fournisseurs.destroy');
    Route::delete('/admin/fournisseurs/{id}/trash', [FournisseurController::class, 'trash'])->name('admin.fournisseurs.trash');
    Route::post('/admin/fournisseurs/{id}/restore', [FournisseurController::class, 'restore'])->name('admin.fournisseurs.restore');
});

// Admin Dashboard & Orders Management
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminOrderController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    });

// Stock Management Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/stock/dashboard', [StockController::class, 'dashboard'])->name('admin.stock.dashboard');
    Route::get('/admin/stock/adjust/{id}', [StockController::class, 'edit'])->name('admin.stock.edit');
    Route::patch('/admin/stock/adjust/{product}', [StockController::class, 'adjust'])->name('admin.stock.adjust');
});