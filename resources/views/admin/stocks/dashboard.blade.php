@extends('adminlte::page')

@section('title', 'Stock Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>
            <i class="fas fa-warehouse"></i> Stock Dashboard
        </h1>
        <small class="text-muted">Monitor and manage your inventory in real-time</small>
    </div>

    <div class="text-right">
        <small class="text-muted">Last updated</small><br>
        <strong>{{ now()->format('M d, Y - H:i') }}</strong>
    </div>
</div>
@stop

@section('content')

{{-- TOP STATS --}}
<div class="row">

    {{-- Inventory Value --}}
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>${{ number_format($product_valeur_inventaire, 2) }}</h3>
                <p>Total Inventory Value</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    {{-- Out of Stock --}}
    <div class="col-md-4">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ count($product_rupture) }}</h3>
                <p>Out of Stock</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    {{-- Critical --}}
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ count($product_stock_critique) }}</h3>
                <p>Critical Stock</p>
            </div>
            <div class="icon">
                <i class="fas fa-bolt"></i>
            </div>
        </div>
    </div>

</div>

{{-- MAIN CARD --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="card-title">
                <i class="fas fa-boxes"></i> Inventory Overview
            </h3>
            <small class="text-muted d-block">Filter and analyze your stock levels</small>
        </div>

        <select id="stockFilter" class="form-control w-auto">
            <option value="all">📊 All Products</option>
            <option value="rupture">🔴 Out of Stock</option>
            <option value="critical">⚠️ Critical Stock</option>
        </select>
    </div>

    {{-- CHART --}}
    <div class="card-body bg-light">
        <div class="card">
            <div class="card-body">
                <h5>
                    <i class="fas fa-chart-pie"></i> Stock Status Distribution
                </h5>
                <div style="height:300px">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    @if(count($product_rupture) || count($product_stock_critique))
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Alert Threshold</th>
                    <th>Current Stock</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="productTable">

                {{-- OUT OF STOCK --}}
                @foreach($product_rupture as $product)
                <tr data-status="rupture">
                    <td>
                        <i class="fas fa-box text-danger mr-2"></i>
                        {{ $product->title }}
                    </td>
                    <td>{{ $product->stock_alert_threshold }}</td>
                    <td>
                        <span class="badge badge-danger badge-lg">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-danger">
                            <i class="fas fa-times-circle"></i> Out of Stock
                        </span>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.stock.edit', $product->id) }}"
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-sliders-h"></i> Adjust
                        </a>
                    </td>
                </tr>
                @endforeach

                {{-- CRITICAL --}}
                @foreach($product_stock_critique as $product)
                <tr data-status="critical">
                    <td>
                        <i class="fas fa-box text-warning mr-2"></i>
                        {{ $product->title }}
                    </td>
                    <td>{{ $product->stock_alert_threshold }}</td>
                    <td>
                        <span class="badge badge-warning badge-lg">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-exclamation-circle"></i> Critical
                        </span>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.stock.edit', $product->id) }}"
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-sliders-h"></i> Adjust
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    @else
        <div class="card-body text-center">
            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
            <h5>All Stock Levels are Healthy!</h5>
            <p class="text-muted">No products require immediate attention.</p>
        </div>
    @endif

</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // FILTER
    document.getElementById('stockFilter').addEventListener('change', function () {
        const value = this.value;
        document.querySelectorAll('#productTable tr').forEach(row => {
            row.style.display =
                (value === 'all' || row.dataset.status === value) ? '' : 'none';
        });
    });

    // CHART
    const ctx = document.getElementById('stockChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Out of Stock', 'Critical Stock'],
            datasets: [{
                data: [{{ count($product_rupture) }}, {{ count($product_stock_critique) }}],
                backgroundColor: ['#dc3545', '#ffc107'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@stop
