<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart;
        $cart->load('products');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $cart = auth()->user()->cart;
        $quantity = $request->quantity ?? 1;

        $existingProduct = $cart->products()->where('product_id', $id)->first();

        if ($existingProduct) {
            $cart->products()->updateExistingPivot($id, [
                'quantity' => $existingProduct->pivot->quantity + $quantity
            ]);
        } else {
            $cart->products()->attach($id, ['quantity' => $quantity]);
        }

        return redirect()->back();
    }

    public function remove($id)
    {
        $cart = auth()->user()->cart;
        $cart->products()->detach($id);
        return redirect()->back();
    }
    
}