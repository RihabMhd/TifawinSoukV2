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


        if ($request->filled(key: 'client')) {
            $search = $request->client;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        $stats = [
            'total_orders' => (clone $query)->count(),
            'total_amount' => (clone $query)->sum('total'),
        ];


        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show($id)
    {

        $order = Order::with(['products', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Statut updated success');
    }
}
