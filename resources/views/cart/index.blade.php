@extends('adminlte::page')

@section('title', 'Mon Panier')

@section('content_header')
<h1><i class="fas fa-shopping-cart"></i> Mon Panier</h1>
@stop

@section('content')

{{-- Alerts --}}
@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="fas fa-times-circle"></i> {{ session('error') }}
</div>
@endif

{{-- Empty cart --}}
@if($cart->items->isEmpty())
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
        <h5>Votre panier est vide</h5>
        <p class="text-muted">Parcourez les produits et ajoutez-les à votre panier.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            <i class="fas fa-store"></i> Découvrir les produits
        </a>
    </div>
</div>

@else

<div class="row">

    {{-- Cart items --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-box"></i> Produits
                </h3>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Produit</th>
                            <th class="text-center">Prix</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-center">Sous-total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/'.$item->product->image) }}"
                                             class="img-thumbnail mr-3"
                                             style="width:60px;height:60px;">
                                    @else
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center mr-3"
                                             style="width:60px;height:60px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif

                                    <a href="{{ route('products.show', $item->product) }}">
                                        {{ $item->product->title ?? $item->product->name }}
                                    </a>
                                </div>
                            </td>

                            <td class="text-center">
                                ${{ number_format($item->price_at_addition, 2) }}
                            </td>

                            <td class="text-center">
                                <form method="POST"
                                      action="{{ route('cart.update', $item) }}"
                                      class="form-inline justify-content-center">
                                    @csrf
                                    @method('PATCH')

                                    <input type="number"
                                           name="quantity"
                                           value="{{ $item->quantity }}"
                                           min="1"
                                           class="form-control form-control-sm mr-2"
                                           style="width:80px">

                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </form>
                            </td>

                            <td class="text-center font-weight-bold">
                                ${{ number_format($item->getSubtotal(), 2) }}
                            </td>

                            <td class="text-center">
                                <form method="POST"
                                      action="{{ route('cart.remove', $item) }}"
                                      onsubmit="return confirm('Supprimer ce produit ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Summary --}}
    <div class="col-lg-4">
        <div class="card position-sticky" style="top:80px">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-receipt"></i> Résumé
                </h3>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Sous-total</span>
                    <strong>${{ number_format($cart->getTotal(), 2) }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Livraison</span>
                    <span class="text-success">Gratuite</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-4">
                    <h4>Total</h4>
                    <h4>${{ number_format($cart->getTotal(), 2) }}</h4>
                </div>

                @auth
                    @if(auth()->user()->role_id == 3)
                        <a href="{{ route('checkout.index') }}"
                           class="btn btn-success btn-block">
                            <i class="fas fa-credit-card"></i> Passer la commande
                        </a>
                    @else
                        <button class="btn btn-secondary btn-block" disabled>
                            Seuls les clients peuvent commander
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Se connecter
                    </a>
                @endauth

                <form method="POST"
                      action="{{ route('cart.clear') }}"
                      class="mt-3"
                      onsubmit="return confirm('Vider le panier ?')">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-link text-danger btn-block">
                        <i class="fas fa-trash"></i> Vider le panier
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endif
@stop
