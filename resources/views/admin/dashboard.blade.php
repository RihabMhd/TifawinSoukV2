@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0">Admin Dashboard</h1>
            <small class="text-muted">
                Bienvenue ! Voici un aperçu de votre activité
            </small>
        </div>
        <div class="text-muted">
            {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
        </div>
    </div>
@stop

@section('content')

{{-- ================= KPI CARDS ================= --}}
<div class="row">

    {{-- CA du jour --}}
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($revenueToday, 2) }} MAD</h3>
                <p>CA du jour</p>
            </div>
            <div class="icon">
                <i class="fas fa-coins"></i>
            </div>
        </div>
    </div>

    {{-- Commandes du jour --}}
    <div class="col-md-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $ordersToday }}</h3>
                <p>Commandes du jour</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>

    {{-- En attente --}}
    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendingOrders }}</h3>
                <p>En attente</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $ordersThisMonth }}</h3>
                <p>Total ce mois</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

</div>

<div class="row">

    {{-- Line chart --}}
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Ventes – 7 derniers jours</h3>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Statut des commandes</h3>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-indigo">
            <div class="card-header">
                <h3 class="card-title">Top 5 produits vendus</h3>
            </div>
            <div class="card-body">
                <canvas id="productsChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Dernières commandes</h3>
        <div class="card-tools">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                Voir tout
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Commande</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ number_format($order->total_amount, 2) }} MAD</td>
                        <td>
                            <span class="badge badge-{{ 
                                $order->status === 'pending' ? 'warning' :
                                ($order->status === 'completed' ? 'success' :
                                ($order->status === 'cancelled' ? 'danger' : 'info'))
                            }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="btn btn-xs btn-info">
                                Détails
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Aucune commande récente
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'CA (MAD)',
                data: @json($chartData),
                borderColor: '#17a2b8',
                fill: false,
                tension: 0.4
            }]
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($statusLabels),
            datasets: [{
                data: @json($statusData),
                backgroundColor: ['#f1c40f', '#2ecc71', '#e74c3c']
            }]
        }
    });

    new Chart(document.getElementById('productsChart'), {
        type: 'bar',
        data: {
            labels: @json($topProducts->pluck('product_name')),
            datasets: [{
                label: 'Quantité vendue',
                data: @json($topProducts->pluck('total_sold')),
                backgroundColor: '#6366f1'
            }]
        }
    });
</script>
@stop
