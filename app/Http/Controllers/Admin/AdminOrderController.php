<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user']);

        // if the user typed a name in the 'client' box
        if ($request->filled('client')) {
            $search = $request->client;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        // if a status was selected in the dropdown
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // calculate numbers for those top boxes in index.blade.php
        $stats = [
            'total_orders' => (clone $query)->count(),
            'total_amount' => (clone $query)->sum('total'),
        ];

        // get the results, newest first, 20 per page
        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show($id)
    {
        // find the order or show a 404 page if it doesn't exist
        $order = Order::with(['products', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        // save the new status sent from the dropdown
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour !');
    }
}