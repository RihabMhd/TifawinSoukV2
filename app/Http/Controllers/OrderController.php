<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // show list of orders
    public function index(Request $request)
    {
        // get all orders for logged user and load products relation
        $orders = auth()->user()->orders()
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // list of all possible statuses 
        $statuses = [
            'pending' => 'En attente',
            'processing' => 'En traitement',
            'shipped' => 'Expédiée',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée'
        ];

        return view('orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        // load relation after you already have the products
        $order->load('products');

        return view('orders.show', compact('order'));
    }

    // cancel an order
    public function cancel(Order $order)
    {
        // check if order belong to logged user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à annuler cette commande.');
        }

        // check if order can be cancelled (only pending or processing)
        if (!$order->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'Cette commande ne peut plus être annulée. Seules les commandes en attente ou en traitement peuvent être annulées.');
        }

        try {
            // give back stock for each product in order
            foreach ($order->products as $product) {
                $quantity = $product->pivot->quantity;
                // add quantity back to product stock
                $product->increment('quantity', $quantity);
            }

            // update order status to cancelled
            $order->update([
                'status' => 'cancelled'
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Votre commande a été annulée avec succès. Les quantités ont été remises en stock.');
        } catch (\Exception $e) {
            // in case of an error
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'annulation de la commande. Veuillez réessayer.');
        }
    }
}