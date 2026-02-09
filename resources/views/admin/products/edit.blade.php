@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1>Edit Product</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update product information</h3>
            </div>

            <form action="{{ route('admin.products.update', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
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
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $product->title) }}"
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

                    {{-- Price --}}
                    <div class="form-group">
                        <label for="price">
                            Price ($) <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               id="price"
                               name="price"
                               step="0.01"
                               min="0"
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $product->price) }}"
                               required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Current Image --}}
                    @if($product->image)
                        <div class="form-group">
                            <label>Current Image</label>
                            <div>
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->title }}"
                                     class="img-thumbnail"
                                     style="max-width: 200px;">
                            </div>
                        </div>
                    @endif

                    {{-- Image --}}
                    <div class="form-group">
                        <label for="image">
                            {{ $product->image ? 'Change Image' : 'Product Image' }}
                        </label>
                        <input type="file"
                               id="image"
                               name="image"
                               class="form-control-file @error('image') is-invalid @enderror"
                               accept="image/*">
                        <small class="form-text text-muted">
                            Accepted formats: JPG, PNG, GIF, WebP (Max: 2MB)
                            @if($product->image)
                                <br>Leave empty to keep current image
                            @endif
                        </small>
                        @error('image')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Footer --}}
                <div class="card-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

@stop
