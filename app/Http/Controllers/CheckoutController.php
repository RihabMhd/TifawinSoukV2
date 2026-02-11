<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Exception;

class CheckoutController extends Controller
{
    // show checkout page
    public function index()
    {
        // get user cart
        $cart = auth()->user()->cart;
        if ($cart->products->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }
        
        return view('checkout.index', compact('cart'));
    }

    // this fucntion process the order when user submit checkout form
    public function process(Request $request)
    {
        // check if all required fields are filled corectly
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

        // get cart and calculate total price
        $cart = auth()->user()->cart;
        $total = $cart->getTotal();

        try {
            $order = Order::create([
                'user_id'      => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()), // unique id xcan give us something like this 6a4b2c8d i used strtoupper to make it upper
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

            // add all products from cart to order : loop 3lihom
            foreach ($cart->products as $product) {
                // attach product to order with quantity and price
                $order->products()->attach($product->id, [
                    'quantity' => $product->pivot->quantity,
                    'price'    => $product->price,
                ]);

                // reduce stock quantity in product table
                $product->decrement('quantity', $product->pivot->quantity);
            }

            // empty the cart after order created
            $cart->products()->detach();


            return redirect()->route('orders.index')->with('success', 'Commande réussie !');

        } catch (\Exception $e) {
            // in case something goes wrong
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
}