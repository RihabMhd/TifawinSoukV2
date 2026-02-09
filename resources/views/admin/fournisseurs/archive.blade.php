@extends('adminlte::page')

@section('title', 'Archive des fournisseurs')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-archive"></i> Archive des fournisseurs
    </h1>

    <a href="{{ route('admin.fournisseurs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>
@stop

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-times-circle"></i> {{ session('error') }}
    </div>
@endif

<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-trash-restore"></i> Fournisseurs archivés
        </h3>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead class="thead-light">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fournisseurs_archives as $fournisseur)
                    <tr>
                        <td>{{ $fournisseur->name }}</td>
                        <td>{{ $fournisseur->email }}</td>
                        <td>{{ $fournisseur->phone }}</td>
                        <td class="text-right">
                            <div class="btn-group">

                                {{-- Restore --}}
                                <form action="{{ route('admin.fournisseurs.restore', $fournisseur->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm btn-warning"
                                            title="Restaurer">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>

                                {{-- Delete permanently --}}
                                <form action="{{ route('admin.fournisseurs.destroy', $fournisseur->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer définitivement ce fournisseur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Supprimer définitivement">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="fas fa-info-circle"></i>
                            Aucun fournisseur archivé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop
