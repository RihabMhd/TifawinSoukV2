@extends('adminlte::page')

@section('title', 'Create Product')

@section('content_header')
    <h1>Create New Product</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">New product information</h3>
            </div>

            <form action="{{ route('admin.products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    {{-- Product Title --}}
                    <div class="form-group">
                        <label for="title">
                            Product Title <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
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
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fournisseur --}}
                    <div class="form-group">
                        <label for="fournisseur_id">Supplier</label>
                        <select id="fournisseur_id"
                                name="fournisseur_id"
                                class="form-control @error('fournisseur_id') is-invalid @enderror">
                            <option value="">No supplier</option>
                            @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}"
                                    {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                                    {{ $fournisseur->name }} — {{ $fournisseur->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('fournisseur_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($fournisseurs->isEmpty())
                            <small class="text-warning">
                                No suppliers available.
                                <a href="{{ route('admin.fournisseurs.create') }}">
                                    Create one
                                </a>
                            </small>
                        @endif
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
                               value="{{ old('price') }}"
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
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file"
                               id="image"
                               name="image"
                               class="form-control-file @error('image') is-invalid @enderror"
                               accept="image/*">
                        <small class="form-text text-muted">
                            Accepted formats: JPG, PNG, GIF, WebP (Max: 2MB)
                        </small>
                        @error('image')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Footer --}}
                <div class="card-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Create Product
                    </button>

                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

@stop
