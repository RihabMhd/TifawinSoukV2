@extends('adminlte::page')

@section('title', 'Gestion des Commandes')

@section('content_header')
    <h1>Gestion des Commandes</h1>
@stop

@section('content')

{{-- ================= STATS ================= --}}
<div class="row">

    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_orders'] }}</h3>
                <p>Total Commandes</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($stats['total_amount'], 2) }} DH</h3>
                <p>Montant Total</p>
            </div>
            <div class="icon">
                <i class="fas fa-coins"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $orders->where('status','pending')->count() }}</h3>
                <p>En attente</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $orders->where('status','delivered')->count() }}</h3>
                <p>Livrées</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

</div>

{{-- ================= FILTERS ================= --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter"></i> Filtres
        </h3>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}">

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Client</label>
                        <input type="text" name="client" value="{{ request('client') }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Statut</label>
                        <select name="status" class="form-control">
                            <option value="">Tous</option>
                            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date début</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date fin</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label>Min</label>
                        <input type="number" name="amount_min" value="{{ request('amount_min') }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label>Max</label>
                        <input type="number" name="amount_max" value="{{ request('amount_max') }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ================= ORDERS TABLE ================= --}}
<div class="card">
    <div class="card-body table-responsive p-0">

        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>

                        <td>
                            <strong>{{ $order->user->name ?? 'Invité' }}</strong><br>
                            <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                        </td>

                        <td>{{ number_format($order->total,2) }} DH</td>

                        <td>
                            <form action="{{ route('admin.orders.updateStatus',$order->id) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <select name="status"
                                        class="form-control form-control-sm
                                        {{ $order->status=='pending'?'bg-warning':'' }}
                                        {{ $order->status=='confirmed'?'bg-info':'' }}
                                        {{ $order->status=='processing'?'bg-info':'' }}
                                        {{ $order->status=='shipped'?'bg-primary':'' }}
                                        {{ $order->status=='delivered'?'bg-success':'' }}
                                        {{ $order->status=='cancelled'?'bg-danger':'' }}"
                                        onchange="if(confirm('Changer le statut ?')) this.form.submit(); else this.value='{{ $order->status }}'">

                                    @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                                        <option value="{{ $s }}" {{ $order->status==$s?'selected':'' }}>
                                            {{ ucfirst($s) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>

                        <td>
                            {{ $order->created_at->format('d/m/Y') }}<br>
                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                        </td>

                        <td>
                            <a href="{{ route('admin.orders.show',$order->id) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Aucune commande trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    @if($orders->hasPages())
        <div class="card-footer">
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

@stop