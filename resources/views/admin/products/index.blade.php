@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-box"></i> Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>
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

@if($products->count() > 0)

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i> Products List
        </h3>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Created By</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->title }}"
                                 class="img-thumbnail"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center"
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-image text-white"></i>
                            </div>
                        @endif
                    </td>

                    <td>
                        <strong>{{ $product->title }}</strong>
                    </td>

                    <td>
                        <span class="badge badge-primary">
                            {{ $product->category->title }}
                        </span>
                    </td>

                    <td>
                        @if($product->fournisseur)
                            {{ $product->fournisseur->name }}
                        @else
                            <span class="text-muted">No supplier</span>
                        @endif
                    </td>

                    <td>
                        <strong class="text-success">
                            ${{ number_format($product->price, 2) }}
                        </strong>
                    </td>

                    <td>
                        @if($product->quantity <= ($product->stock_alert_threshold ?? 10))
                            <span class="badge badge-danger">
                                {{ $product->quantity }}
                            </span>
                        @else
                            <span class="badge badge-success">
                                {{ $product->quantity }}
                            </span>
                        @endif
                    </td>

                    <td>
                        {{ $product->user->name }}
                    </td>

                    <td class="text-right">
                        <a href="{{ route('products.show', $product->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
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

@else

{{-- Empty state --}}
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-box fa-3x text-muted mb-3"></i>
        <h5>No products</h5>
        <p class="text-muted">Get started by creating a new product.</p>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
</div>

@endif
@stop