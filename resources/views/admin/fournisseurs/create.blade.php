@extends('adminlte::page')

@section('title', 'Ajouter un fournisseur')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-truck"></i> Ajouter un fournisseur
    </h1>

    <a href="{{ route('admin.fournisseurs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Erreur :</strong> veuillez corriger les champs ci-dessous.
    </div>
@endif

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-plus"></i> Informations du fournisseur
        </h3>
    </div>

    <form action="{{ route('admin.fournisseurs.store') }}" method="POST">
        @csrf

        <div class="card-body">

            {{-- Nom --}}
            <div class="form-group">
                <label for="name">Nom <span class="text-danger">*</span></label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       required>

                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required>

                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Téléphone --}}
            <div class="form-group">
                <label for="phone">Téléphone <span class="text-danger">*</span></label>
                <input type="text"
                       name="phone"
                       id="phone"
                       value="{{ old('phone') }}"
                       class="form-control @error('phone') is-invalid @enderror"
                       required>

                @error('phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.fournisseurs.index') }}" class="btn btn-secondary mr-2">
                Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

@stop
