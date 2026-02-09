<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }


    public function dashboard()
    {
        // chiffre daffaires du jour
        $revenueToday = Order::whereDate('created_at', today())
            ->sum('total');

        //  Commandes du jour
        $ordersToday = Order::whereDate('created_at', today())
            ->count();

        //  Commandes en attente
        $pendingOrders = Order::where('status', 'pending')
            ->count();

        // Commandes du mois
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Top five products vendus
        $topProducts = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.title as product_name',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('products.title')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Ventes 7 derniere jours
        $salesLast7Days = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $salesLast7Days->pluck('date');
        $chartData   = $salesLast7Days->pluck('total');

        // Commandes récentes (Recents Orders)
        $recentOrders = Order::latest()
            ->take(5)
            ->get();

        // Statut des commandes (Chart data)
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

    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }



    public function updateStatus($id)
    {
        $status = Request::input('status');


        if (!in_array($status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
            return redirect()->back()->with('error', 'Statut invalide');
        }

        $order = Order::findOrFail($id);
        $order->status = $status;
        $order->save();

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Statut de la commande mis à jour avec succès');
    }
}
