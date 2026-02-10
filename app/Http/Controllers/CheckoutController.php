<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Exception;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart;
        if ($cart->products->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }
        return view('checkout.index', compact('cart'));
    }

public function process(Request $request)
{
   
    $request->validate([
        'first_name'  => 'required',
        'last_name'   => 'required',
        'email'       => 'required|email',
        'phone'       => 'required',
        'address'     => 'required',
        'city'        => 'required',
        'postal_code' => 'required',
        'country'     => 'required',
    ]);

    $cart = auth()->user()->cart;
    $total = $cart->getTotal();

    try {
        // 1. création de la commande principale
        $order = Order::create([
            'user_id'      => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'total'        => $total,
            'status'       => 'pending',
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'city'         => $request->city,
            'postal_code'  => $request->postal_code,
            'country'      => $request->country,
        ]);

        // 2. ajout des produits à la commande
        foreach ($cart->products as $product) {
            $order->products()->attach($product->id, [
                'quantity' => $product->pivot->quantity,
                'price'    => $product->price,
            ]);

            // mise à jour du stock
            $product->decrement('quantity', $product->pivot->quantity);
        }

        $cart->products()->detach();

        return redirect()->route('orders.index')->with('success', 'Commande réussie !');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}
}