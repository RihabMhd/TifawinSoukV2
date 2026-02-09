@extends('adminlte::page')

@section('title', 'Commande #' . $order->id)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Commande #{{ $order->id }}</h1>
        <small class="text-muted">
            Créée le {{ $order->created_at->format('d/m/Y à H:i') }}
        </small>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>
@stop

@section('content')

{{-- ALERTS --}}
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    </div>
@endif

<div class="row">

    {{-- LEFT COLUMN --}}
    <div class="col-md-8">

        {{-- ORDER ITEMS --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-box"></i> Articles commandés
                </h3>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Qté</th>
                            <th class="text-right">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product->title ?? 'Produit supprimé' }}</strong>
                                    @if($item->product && $item->product->sku)
                                        <br><small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                    @endif
                                </td>
                                <td>{{ number_format($item->price,2) }} MAD</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-right font-weight-bold">
                                    {{ number_format($item->price * $item->quantity,2) }} MAD
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Aucun article
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- TOTALS --}}
            <div class="card-footer">
                <div class="float-right" style="width:300px">
                    <p class="d-flex justify-content-between">
                        <span>Sous-total</span>
                        <span>{{ number_format($order->total,2) }} MAD</span>
                    </p>

                    @if($order->shipping_cost > 0)
                        <p class="d-flex justify-content-between">
                            <span>Livraison</span>
                            <span>{{ number_format($order->shipping_cost,2) }} MAD</span>
                        </p>
                    @endif

                    @if($order->tax > 0)
                        <p class="d-flex justify-content-between">
                            <span>TVA</span>
                            <span>{{ number_format($order->tax,2) }} MAD</span>
                        </p>
                    @endif

                    <hr>
                    <h4 class="d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ number_format($order->total,2) }} MAD</strong>
                    </h4>
                </div>
            </div>
        </div>

        {{-- CUSTOMER --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i> Client
                </h3>
            </div>
            <div class="card-body">
                <p><strong>Nom:</strong> {{ $order->user->name ?? 'Invité' }}</p>
                <p><strong>Email:</strong> {{ $order->user->email ?? $order->email ?? 'N/A' }}</p>
                <p><strong>Téléphone:</strong> {{ $order->phone ?? 'N/A' }}</p>
                <p><strong>Client depuis:</strong>
                    {{ $order->user ? $order->user->created_at->format('d/m/Y') : 'N/A' }}
                </p>
            </div>
        </div>

        {{-- SHIPPING --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-truck"></i> Adresse de livraison
                </h3>
            </div>
            <div class="card-body">
                <p>{{ $order->first_name ?? '' }} {{ $order->last_name ?? '' }}</p>
                <p>{{ $order->shipping_address ?? $order->address }}</p>
                <p>{{ $order->postal_code }} {{ $order->city }}</p>
                <p>{{ $order->country }}</p>
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN --}}
    <div class="col-md-4">

        {{-- STATUS --}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-sync"></i> Statut
                </h3>
            </div>

            <form action="{{ route('admin.orders.updateStatus',$order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label>Statut</label>
                        <select name="status" class="form-control">
                            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status==$s?'selected':'' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <span class="badge badge-{{ 
                        $order->status=='pending'?'warning':
                        ($order->status=='processing'?'info':
                        ($order->status=='shipped'?'primary':
                        ($order->status=='delivered'?'success':'danger'))) 
                    }} p-2 w-100 text-center">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>

        {{-- PAYMENT --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-credit-card"></i> Paiement
                </h3>
            </div>
            <div class="card-body">
                <p>
                    <strong>Méthode:</strong><br>
                    <span class="badge badge-info">
                        {{ $order->payment_method ?? 'Paiement à la livraison' }}
                    </span>
                </p>

                @if($order->payment_status)
                    <p>
                        <strong>Statut:</strong><br>
                        <span class="badge badge-{{ $order->payment_status=='paid'?'success':'warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                @endif

                <p class="mt-3">
                    <strong>Total:</strong><br>
                    <span class="h4 text-primary">
                        {{ number_format($order->total,2) }} MAD
                    </span>
                </p>
            </div>
        </div>

        {{-- NOTES --}}
        @if($order->order_notes)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-sticky-note"></i> Notes
                </h3>
            </div>
            <div class="card-body">
                {{ $order->order_notes }}
            </div>
        </div>
        @endif

    </div>
</div>

@stop
