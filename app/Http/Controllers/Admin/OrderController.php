<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Client search
        if ($request->filled('client_search')) {
            $search = $request->client_search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        // Amount filter
        if ($request->filled('amount_min')) {
            $query->where('total', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('total', '<=', $request->amount_max);
        }

        // Sorting
        $allowedSorts = ['created_at', 'total', 'order_number'];
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $order);
        } else {
            $query->latest();
        }

        // Stats
        $statsQuery = clone $query;
        $stats = [
            'total_orders' => $statsQuery->count(),
            'total_amount' => $statsQuery->sum('total'),
        ];

        // Pagination
        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    //Dashboard admin
    public function dashboard()
    {
        $revenueToday = Order::whereDate('created_at', today())->sum('total');
        $ordersToday = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $topProducts = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.title as product_name',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('products.id', 'products.title')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $salesLast7Days = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $salesLast7Days->pluck('date');
        $chartData = $salesLast7Days->pluck('total');

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $statusLabels = $ordersByStatus->pluck('status');
        $statusData = $ordersByStatus->pluck('count');

        return view('admin.dashboard', compact(
            'revenueToday',
            'ordersToday',
            'pendingOrders',
            'ordersThisMonth',
            'topProducts',
            'chartLabels',
            'chartData',
            'recentOrders',
            'statusLabels',
            'statusData'
        ));
    }

    //Show order
    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    //Update order
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour avec succès');
    }

    //Cancel order
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'delivered') {
            return back()->with('error', 'Impossible d\'annuler une commande livrée');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Commande annulée avec succès');
    }
}
