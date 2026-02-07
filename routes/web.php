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

use PHPUnit\Metadata\Group;

require __DIR__ . '/auth.php';

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);

    Route::put('/admin/orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');

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


require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {



        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        Route::delete('/orders/{order}', [AdminOrderController::class, 'cancel'])
            ->name('orders.cancel');
        Route::get('/stock/dashboard', [StockController::class, 'dashboard'])->name('admin.stock.dashboard');
        Route::get('/dashboard', [AdminOrderController::class, 'dashboard'])->name('dashboard');
    });


    // ================================== stocks ======================
use App\Models\Cart;

Route::get('/debug-cart', function () {
    $output = [];
    
    $output[] = "=== CURRENT SESSION INFO ===";
    $output[] = "Session ID: " . session()->getId();
    $output[] = "Authenticated: " . (auth()->check() ? 'YES' : 'NO');
    if (auth()->check()) {
        $output[] = "User ID: " . auth()->id();
        $output[] = "User Email: " . auth()->user()->email;
        $output[] = "User Role ID: " . auth()->user()->role_id;
    }
    $output[] = "";
    
    $output[] = "=== ALL CARTS IN DATABASE ===";
    $carts = Cart::with('items')->get();
    $output[] = "Total carts: " . $carts->count();
    $output[] = "";
    
    foreach ($carts as $cart) {
        $output[] = "Cart ID: " . $cart->id;
        $output[] = "  User ID: " . ($cart->user_id ?? 'NULL');
        $output[] = "  Session ID: " . ($cart->session_id ?? 'NULL');
        $output[] = "  Items count: " . $cart->items->count();
        
        if ($cart->items->count() > 0) {
            $output[] = "  Items:";
            foreach ($cart->items as $item) {
                $output[] = "    - Product ID: " . $item->product_id . ", Qty: " . $item->quantity;
            }
        }
        $output[] = "";
    }
    
    return '<pre>' . implode("\n", $output) . '</pre>';
});