@extends('adminlte::page')

@section('title', 'Fournisseurs')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-truck"></i> Liste des fournisseurs
    </h1>

    <div>
        <a href="{{ route('admin.fournisseurs.create') }}" class="btn btn-primary mr-2">
            <i class="fas fa-plus"></i> Ajouter
        </a>

        <a href="{{ route('admin.fournisseurs.archive') }}" class="btn btn-warning">
            <i class="fas fa-archive"></i> Archive
        </a>
    </div>
</div>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i> Fournisseurs
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
                @forelse ($fournisseurs as $fournisseur)
                    <tr>
                        <td>
                            <strong>{{ $fournisseur->name }}</strong>
                        </td>
                        <td>{{ $fournisseur->email }}</td>
                        <td>{{ $fournisseur->phone ?? '—' }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.fournisseurs.edit', $fournisseur->id) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.fournisseurs.trash', $fournisseur->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Archiver ce fournisseur ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Aucun fournisseur trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($fournisseurs, 'links'))
        <div class="card-footer clearfix">
            {{ $fournisseurs->links() }}
        </div>
    @endif
</div>

@stop
