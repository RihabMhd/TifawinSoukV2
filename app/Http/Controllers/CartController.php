<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // get cart from logged user
        $cart = auth()->user()->cart;
        // load products relation so we can see what inside
        $cart->load('products');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        // get user cart
        $cart = auth()->user()->cart;
        // how many items user want our default is 1
        $quantity = $request->quantity ?? 1;

        // check if product already in cart
        $existingProduct = $cart->products()->where('product_id', $id)->first();

        // if product exist already
        if ($existingProduct) {
            // update quantity, add new quantity to old one like we have the product already in 
            // the cart and the user added it again the quantity increment 
            $cart->products()->updateExistingPivot($id, [
                'quantity' => $existingProduct->pivot->quantity + $quantity
            ]);
        } else {
            // product not in cart, add new one
            // attach : create new relationship in pivot table betseen the product and the cart
            $cart->products()->attach($id, ['quantity' => $quantity]);
        }

        // back : go to previous page user was on
        return redirect()->back();
    }

    public function remove($id)
    {
        $cart = auth()->user()->cart;
        // detach : remove relationship between cart and product in pivot table 
        $cart->products()->detach($id);
        return redirect()->back();
    }
    
}