@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-edit"></i> Edit Product
    </h1>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-box"></i> Product Details
                </h3>
            </div>

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {{-- Title --}}
                    <div class="form-group">
                        <label for="title">
                            Product Title <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title', $product->title) }}"
                               class="form-control @error('title') is-invalid @enderror"
                               required>

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="form-group">
                        <label for="category_id">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select id="category_id"
                                name="category_id"
                                class="form-control @error('category_id') is-invalid @enderror"
                                required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Supplier --}}
                    <div class="form-group">
                        <label for="fournisseur_id">Supplier</label>
                        <select id="fournisseur_id"
                                name="fournisseur_id"
                                class="form-control @error('fournisseur_id') is-invalid @enderror">
                            <option value="">No supplier</option>
                            @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}"
                                    {{ old('fournisseur_id', $product->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                                    {{ $fournisseur->name }} - {{ $fournisseur->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('fournisseur_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($fournisseurs->isEmpty())
                            <small class="form-text text-warning">
                                No suppliers available. <a href="{{ route('admin.fournisseurs.create') }}">Create one</a>
                            </small>
                        @endif
                    </div>

                    <div class="row">
                        {{-- Price --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">
                                    Price ($) <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       id="price"
                                       name="price"
                                       value="{{ old('price', $product->price) }}"
                                       step="0.01"
                                       min="0"
                                       class="form-control @error('price') is-invalid @enderror"
                                       required>

                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Quantity --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">
                                    Quantity in Stock <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       value="{{ old('quantity', $product->quantity) }}"
                                       min="0"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       required>

                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Stock Alert Threshold --}}
                    <div class="form-group">
                        <label for="stock_alert_threshold">Stock Alert Threshold</label>
                        <input type="number"
                               id="stock_alert_threshold"
                               name="stock_alert_threshold"
                               value="{{ old('stock_alert_threshold', $product->stock_alert_threshold ?? 10) }}"
                               min="0"
                               class="form-control @error('stock_alert_threshold') is-invalid @enderror">
                        <small class="form-text text-muted">
                            You'll receive an alert when stock falls below this number
                        </small>

                        @error('stock_alert_threshold')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Optional product description">{{ old('description', $product->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Current Image Preview --}}
                    @if($product->image)
                    <div class="form-group">
                        <label>Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->title }}"
                                 class="img-thumbnail"
                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        </div>
                    </div>
                    @endif

                    {{-- Image Upload --}}
                    <div class="form-group">
                        <label for="image">{{ $product->image ? 'Change Image' : 'Product Image' }}</label>
                        <div class="custom-file">
                            <input type="file"
                                   id="image"
                                   name="image"
                                   accept="image/*"
                                   class="custom-file-input @error('image') is-invalid @enderror">
                            <label class="custom-file-label" for="image">Choose file</label>

                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">
                            Accepted formats: JPG, PNG, GIF, WebP (Max: 2MB)
                            @if($product->image)
                                <br>Leave empty to keep current image
                            @endif
                        </small>
                    </div>

                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@stop

@section('js')
<script>
$('#image').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').html(fileName);
});
</script>
@stop