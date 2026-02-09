@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-tags"></i> Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Category
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

@if($categories->count() > 0)

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i> Categories List
        </h3>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Created By</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>
                        <strong>{{ $category->title }}</strong>
                    </td>

                    <td style="max-width:300px">
                        <span class="text-muted">
                            {{ $category->description ?? 'No description' }}
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-info">
                            {{ $category->products_count }}
                            {{ Str::plural('product', $category->products_count) }}
                        </span>
                    </td>

                    <td>
                        {{ $category->user->name }}
                    </td>

                    <td class="text-right">
                        <a href="{{ route('categories.show', $category->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('categories.edit', $category->id) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('categories.destroy', $category->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this category?')">
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
        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
        <h5>No categories</h5>
        <p class="text-muted">Get started by creating a new category.</p>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>
</div>

@endif
@stop
