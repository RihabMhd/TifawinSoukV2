@extends('adminlte::page')

@section('title', $category->title)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-tag"></i> {{ $category->title }}
    </h1>

    <div>
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>
@stop

@section('content')

{{-- Category Info --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Category Information
        </h3>
    </div>

    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Title</dt>
            <dd class="col-sm-9 font-weight-bold">{{ $category->title }}</dd>

            @if($category->description)
                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9 text-muted">{{ $category->description }}</dd>
            @endif

            <dt class="col-sm-3">Created By</dt>
            <dd class="col-sm-9">{{ $category->user->name }}</dd>

            <dt class="col-sm-3">Created At</dt>
            <dd class="col-sm-9">
                {{ $category->created_at->format('F j, Y, g:i a') }}
            </dd>
        </dl>
    </div>
</div>

{{-- Products --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-box"></i>
            Products in this Category ({{ $category->products->count() }})
        </h3>
    </div>

    <div class="card-body">
        @if($category->products->count() > 0)

        <div class="row">
            @foreach($category->products as $product)
            <div class="col-md-4 mb-3">
                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                    <div class="card h-100 card-outline card-primary">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-dark">
                                {{ $product->title }}
                            </h5>

                            <p class="text-success font-weight-bold mb-1">
                                ${{ number_format($product->price, 2) }}
                            </p>

                            @if($product->description)
                                <p class="text-muted text-sm">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        @else
            <div class="text-center text-muted py-4">
                <i class="fas fa-box-open fa-2x mb-2"></i>
                <p>No products in this category yet.</p>
            </div>
        @endif
    </div>
</div>

@stop
