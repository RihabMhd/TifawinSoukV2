<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);

    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // route GET create
    Route::get('/admin/fournisseurs/create', [FournisseurController::class, 'create'])->name('admin.fournisseurs.create');
    // route GET archive
    Route::get('/admin/fournisseurs/archive', [FournisseurController::class, 'archive'])->name('admin.fournisseurs.archive');
    // route POST store
    Route::post('/admin/fournisseurs', [FournisseurController::class, 'store'])->name('admin.fournisseurs.store');
    // route GET edit
    Route::get('/admin/fournisseurs/edit/{id}', [FournisseurController::class, 'edit'])->name('admin.fournisseurs.edit');
    // route PUT update
    Route::put('/admin/fournisseurs/{id}/update', [FournisseurController::class, 'update'])->name('admin.fournisseurs.update');
    // route GET index
    Route::get('/admin/fournisseurs', [FournisseurController::class, 'index'])->name('admin.fournisseurs.index');
    // route DELETE destroy
    Route::delete('/admin/fournisseurs/{id}', [FournisseurController::class, 'destroy'])->name('admin.fournisseurs.destroy');
    // route DELETE trash
    Route::delete('/admin/fournisseurs/{id}/trash', [FournisseurController::class, 'trash'])->name('admin.fournisseurs.trash');
    // route POST restore
    Route::post('/admin/fournisseurs/{id}/restore', [FournisseurController::class, 'restore'])->name('admin.fournisseurs.restore');
});

require __DIR__.'/auth.php';
