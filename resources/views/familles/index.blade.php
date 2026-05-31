@extends('layouts.app')
@section('title', 'Familles de produits')

@section('content')
<div class="page-header">
    <h1 class="page-title">Familles de produits</h1>
    @can('familles.creer')
    <a href="{{ route('familles.create') }}" class="btn btn-primary">+ Nouvelle famille</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Nb produits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($familles as $famille)
                <tr>
                    <td class="text-400 font-mono">{{ $famille->id }}</td>
                    <td class="fw-600 text-900">{{ $famille->nom }}</td>
                    <td class="text-500">{{ $famille->description ?? '—' }}</td>
                    <td>
                        <span class="badge badge-accent">{{ $famille->produits_count }}</span>
                    </td>
                    <td class="actions-cell">
                        @can('familles.voir')
                        <a href="{{ route('familles.show', $famille) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('familles.modifier')
                        <a href="{{ route('familles.edit', $famille) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endcan
                        @can('familles.supprimer')
                        <form action="{{ route('familles.destroy', $famille) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer cette famille ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon">🗂</div>
                            <div class="empty-state-text">Aucune famille enregistrée.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $familles->links() }}</div>
</div>
@endsection
