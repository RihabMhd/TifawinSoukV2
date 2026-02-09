@extends('adminlte::page')

@section('title', $product->title)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-box"></i> {{ $product->title }}
    </h1>

    <div>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>

        <a href="{{ route('products.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>
@stop

@section('content')

<div class="row">
    {{-- Product Info --}}
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Product Information
                </h3>
            </div>

            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Title</dt>
                    <dd class="col-sm-9 font-weight-bold">{{ $product->title }}</dd>

                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">
                        <span class="badge badge-primary">
                            {{ $product->category->title }}
                        </span>
                    </dd>

                    @if($product->fournisseur)
                        <dt class="col-sm-3">Supplier</dt>
                        <dd class="col-sm-9">{{ $product->fournisseur->name }}</dd>
                    @endif

                    <dt class="col-sm-3">Price</dt>
                    <dd class="col-sm-9">
                        <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                    </dd>

                    <dt class="col-sm-3">Stock Quantity</dt>
                    <dd class="col-sm-9">
                        @if($product->quantity <= ($product->stock_alert_threshold ?? 10))
                            <span class="badge badge-danger badge-lg">
                                {{ $product->quantity }} units
                            </span>
                            <small class="text-danger d-block">Low stock alert!</small>
                        @else
                            <span class="badge badge-success badge-lg">
                                {{ $product->quantity }} units
                            </span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Alert Threshold</dt>
                    <dd class="col-sm-9">{{ $product->stock_alert_threshold ?? 10 }} units</dd>

                    @if($product->description)
                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9 text-muted">{{ $product->description }}</dd>
                    @endif

                    <dt class="col-sm-3">Created By</dt>
                    <dd class="col-sm-9">{{ $product->user->name }}</dd>

                    <dt class="col-sm-3">Created At</dt>
                    <dd class="col-sm-9">
                        {{ $product->created_at->format('F j, Y, g:i a') }}
                    </dd>

                    @if($product->updated_at != $product->created_at)
                        <dt class="col-sm-3">Last Updated</dt>
                        <dd class="col-sm-9">
                            {{ $product->updated_at->format('F j, Y, g:i a') }}
                        </dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    {{-- Product Image --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-image"></i> Product Image
                </h3>
            </div>

            <div class="card-body text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->title }}"
                         class="img-fluid rounded"
                         style="max-height: 400px; object-fit: cover;">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center rounded"
                         style="height: 300px;">
                        <div class="text-center">
                            <i class="fas fa-image fa-5x text-white-50 mb-3"></i>
                            <p class="text-white">No image available</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Additional Actions --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cog"></i> Actions
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $product->quantity }}</h3>
                        <p>Units in Stock</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cubes"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>${{ number_format($product->price, 2) }}</h3>
                        <p>Unit Price</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>${{ number_format($product->price * $product->quantity, 2) }}</h3>
                        <p>Total Value</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-group" role="group">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Product
            </a>

            <form action="{{ route('admin.products.destroy', $product->id) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Product
                </button>
            </form>
        </div>
    </div>
</div>

@stop