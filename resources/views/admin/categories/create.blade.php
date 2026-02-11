@extends('adminlte::page')

@section('title', 'Create Category')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-plus-circle"></i> Create New Category
    </h1>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tag"></i> Category Information
                </h3>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    {{-- Title --}}
                    <div class="form-group">
                        <label for="title">
                            Category Title <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Enter category title"
                               required>

                        @error('title')
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
                                  placeholder="Optional description">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Category
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@stop
