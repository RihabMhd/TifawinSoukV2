<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the users orders
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        // make sure the user can view his own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cette commande.');
        }

        // load the order items with products
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à annuler cette commande.');
        }

        // only allow cancelltion if order status is pending
        if ($order->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Cette commande ne peut plus être annulée.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Votre commande a été annulée avec succès.');
    }

    
}