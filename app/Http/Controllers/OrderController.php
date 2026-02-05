<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders
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
        // Make sure the user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cette commande.');
        }

        // Load the order items with products
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order (only if pending)
     */
    public function cancel(Order $order)
    {
        // Make sure the user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à annuler cette commande.');
        }

        // Only allow cancellation if order is pending
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