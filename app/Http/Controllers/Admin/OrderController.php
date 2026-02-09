<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function dashboard()
    {
        // chiffre daffaires du jour
        //where with dates created_at, updated....
        $revenueToday = Order::whereDate('created_at', today())
            ->sum('total');
            // dd($revenueToday);

        //  Commandes du jour
        $ordersToday = Order::whereDate('created_at', today())
            ->count();

        //  Commandes en attente
        //where with colones
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
        public function index(Request $request)
        {
         $query = Order::with(['user','items']);
         if($request->filled('status')){
            $query->where('status',$request->status);
         }
         if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('client_search')) {
            $searchTerm = $request->client_search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Filter by Minimum Amount

        if ($request->filled('amount_min')) {
            $query->where('total', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('total', '<=', $request->amount_max);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        // Allowed sort columns validation to prevent errors
        $allowedSorts = ['created_at', 'total', 'status', 'order_number'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        // Calculate Statistics

        $statsQuery = clone $query;
        $stats = [
            'total_orders' => $statsQuery->count(),
            'total_amount' => $statsQuery->sum('total')
        ];

        // Pagination
        $orders = $query->paginate(20);

        // Return View
        return view('admin.orders.index', compact('orders', 'stats'));
        }

}
