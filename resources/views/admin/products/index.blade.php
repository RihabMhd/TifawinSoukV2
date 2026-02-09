@extends('adminlte::page')

@section('title', 'Products Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Products Management</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
@stop

@section('content')

{{-- Alerts --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- Search & Filter --}}
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('products.index') }}" class="form-inline">

            <div class="form-group mr-2 mb-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Search products...">
            </div>

            <div class="form-group mr-2 mb-2">
                <select name="category_id" class="form-control">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }} ({{ $category->products_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-info mr-2 mb-2">
                <i class="fas fa-filter"></i> Filter
            </button>

            @if(request('search') || request('category_id'))
                <a href="{{ route('products.index') }}" class="btn btn-secondary mb-2">
                    Reset
                </a>
            @endif

        </form>
    </div>
</div>

{{-- Products Table --}}
@if($products->count() > 0)

<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Added By</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                    <tr>
                        {{-- Image --}}
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="img-thumbnail"
                                     style="width:60px;height:60px;object-fit:cover;">
                            @else
                                <span class="badge badge-secondary">No image</span>
                            @endif
                        </td>

                        {{-- Product --}}
                        <td>
                            <strong>{{ $product->title }}</strong>
                            @if($product->description)
                                <br>
                                <small class="text-muted">
                                    {{ \Illuminate\Support\Str::limit($product->description, 50) }}
                                </small>
                            @endif
                        </td>

                        {{-- Category --}}
                        <td>
                            <span class="badge badge-info">
                                {{ $product->category->title ?? 'N/A' }}
                            </span>
                        </td>

                        {{-- Supplier --}}
                        <td>
                            @if($product->fournisseur)
                                <strong>{{ $product->fournisseur->name }}</strong><br>
                                <small class="text-muted">{{ $product->fournisseur->email }}</small>
                            @else
                                <em class="text-muted">No supplier</em>
                            @endif
                        </td>

                        {{-- Price --}}
                        <td>${{ number_format($product->price, 2) }}</td>

                        {{-- Stock --}}
                        <td>
                            @if(isset($product->quantity))
                                @if($product->quantity > 0)
                                    <span class="badge badge-success">
                                        {{ $product->quantity }} in stock
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        Out of stock
                                    </span>
                                @endif
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        {{-- Added by --}}
                        <td>{{ $product->user->name ?? 'N/A' }}</td>

                        {{-- Date --}}
                        <td>{{ $product->created_at->format('d/m/Y') }}</td>

                        {{-- Actions --}}
                        <td class="text-right">
                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-xs btn-info"
                               title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="btn btn-xs btn-primary"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-xs btn-danger"
                                        title="Delete">
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

<div class="mt-3">
    {{ $products->links('pagination::bootstrap-4') }}
</div>

@else

{{-- Empty state --}}
<div class="card">
    <div class="card-body text-center">
        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
        <h5>
            @if(request('search') || request('category_id'))
                No products found
            @else
                No products yet
            @endif
        </h5>
        <p class="text-muted">
            @if(request('search') || request('category_id'))
                Try adjusting your search or filter criteria.
            @else
                Get started by creating a new product.
            @endif
        </p>

        @if(!request('search') && !request('category_id'))
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                Add Product
            </a>
        @endif
    </div>
</div>

@endif

@stop
