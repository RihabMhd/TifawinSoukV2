<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // stats
        $revenueToday = Order::whereDate('created_at', today())->sum('total');
        $ordersToday = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)->count();

        // 7 days sales
        $salesData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')->get();

        // orders by Status
        $statusStats = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->get();

        // recent table
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'revenueToday' => $revenueToday,
            'ordersToday' => $ordersToday,
            'pendingOrders' => $pendingOrders,
            'ordersThisMonth' => $ordersThisMonth,
            'recentOrders' => $recentOrders,
            'chartLabels' => $salesData->pluck('date'),
            'chartData' => $salesData->pluck('total'),
            'statusLabels' => $statusStats->pluck('status'),
            'statusData' => $statusStats->pluck('count'),
            'topProducts' => collect() 
        ]);
    }
}
