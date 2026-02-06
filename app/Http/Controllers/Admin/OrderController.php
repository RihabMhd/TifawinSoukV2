<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function dashboard()
    {
        // chiffre daffaires du jour
        
        $revenueToday = Order::whereDate('created_at', today())
            ->sum('total_amount');

        //  Commandes du jour
        $ordersToday = Order::whereDate('created_at', today())
            ->count();

        //  Commandes en attente
        $pendingOrders = Order::where('status', 'En attente')
            ->count();

        // Commandes du mois
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Top fivee produits vendus
        $topProducts = OrderItem::select(
                'product_name',
                DB::raw('SUM(quantity) as total_sold')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Ventes 7 derniere jours
        $salesLast7Days = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $salesLast7Days->pluck('date');
        $chartData   = $salesLast7Days->pluck('total');

        return view('admin.orders.dashboard', compact(
            'revenueToday',
            'ordersToday',
            'pendingOrders',
            'ordersThisMonth',
            'topProducts',
            'chartLabels',
            'chartData'
        ));
    }

}
