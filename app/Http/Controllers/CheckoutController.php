<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form
     */
    public function index()
    {
        $cart = Cart::getOrCreate();

        // redirect if cart is vide
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide.');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Process the checkout form
     */
    public function process(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'address_complement' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:2',
            'payment_method' => 'required|in:credit_card,paypal,cash_on_delivery',
            'order_notes' => 'nullable|string|max:1000',
            'terms_accepted' => 'required|accepted',
        ]);

        $cart = Cart::getOrCreate();

        // Check if cart is still valid
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide.');
        }

        try {
            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',

                // Shipping information
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'address_complement' => $validated['address_complement'] ?? null,
                'postal_code' => $validated['postal_code'],
                'city' => $validated['city'],
                'country' => $validated['country'],

                // Payment and totals
                'payment_method' => $validated['payment_method'],
                'subtotal' => $cart->getTotal(),
                'tax' => $cart->getTotal() * 0.20, // 20% TVA
                'total' => $cart->getTotal() * 1.20,

                // Notes
                'order_notes' => $validated['order_notes'] ?? null,
            ]);

            // Create order items from cart items
            foreach ($cart->items as $cartItem) {

                if ($cartItem->product->quantity < $cartItem->quantity) {
                    return redirect()->back()->with('error', "Stock insuffisant pour {$cartItem->product->title}");
                }
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price_at_addition,
                    'subtotal' => $cartItem->getSubtotal(),
                ]);
                
                $cartItem->product->decrement('quantity', $cartItem->quantity);
            }

            // Clear the cart
            $cart->items()->delete();

            // Redirect to order confirmation page
            return redirect()->route('orders.show', $order)
                ->with('success', 'Votre commande a été passée avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de votre commande. Veuillez réessayer.');
        }
    }

    /**
     * Generate a unique order number
     */
    private function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}
