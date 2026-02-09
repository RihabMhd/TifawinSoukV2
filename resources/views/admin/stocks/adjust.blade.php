@extends('adminlte::page')

@section('title', 'Adjust Stock')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-boxes"></i>
        Adjust Stock — {{ $product->title }}
    </h1>

    <a href="{{ route('admin.stock.dashboard') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>
@stop

@section('content')

{{-- Success --}}
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- Error --}}
@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-times-circle"></i> {{ session('error') }}
    </div>
@endif

{{-- Product Info --}}
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Product Details
        </h3>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                <p class="mb-1 text-muted">Product Name</p>
                <h4>{{ $product->title }}</h4>

                <p class="mt-3 mb-1 text-muted">Description</p>
                <p>{{ $product->description ?? 'No description available' }}</p>
            </div>

            <div class="col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>${{ number_format($product->price, 2) }}</h3>
                        <p>Current Price</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-cubes"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Current Stock</span>
                                <span class="info-box-number">{{ $product->quantity }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Alert Threshold</span>
                                <span class="info-box-number">{{ $product->stock_alert_threshold }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Adjust Form --}}
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-sliders-h"></i> Stock Adjustment
        </h3>
    </div>

    <form action="{{ route('admin.stock.adjust', $product) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="card-body">
            <div class="row">

                {{-- Quantity --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            New Quantity <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               name="quantity"
                               value="{{ old('quantity', $product->quantity) }}"
                               min="0"
                               required
                               class="form-control @error('quantity') is-invalid @enderror">

                        @error('quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                        <small class="form-text text-muted">
                            Current stock: {{ $product->quantity }} units
                        </small>
                    </div>
                </div>

                {{-- Alert Threshold --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Alert Threshold <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               name="stock_alert_threshold"
                               value="{{ old('stock_alert_threshold', $product->stock_alert_threshold) }}"
                               min="0"
                               required
                               class="form-control @error('stock_alert_threshold') is-invalid @enderror">

                        @error('stock_alert_threshold')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                        <small class="form-text text-muted">
                            Notify when stock goes below this value
                        </small>
                    </div>
                </div>

            </div>

            {{-- Info --}}
            <div class="alert alert-info mt-3">
                <i class="fas fa-lightbulb"></i>
                <strong>Tips:</strong>
                <ul class="mb-0 mt-2">
                    <li>Set alert threshold to 10–20% of monthly sales</li>
                    <li>Update stock after receiving shipments</li>
                    <li>Check inventory weekly</li>
                </ul>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.stock.dashboard') }}" class="btn btn-secondary mr-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Stock
            </button>
        </div>
    </form>
</div>

@stop
