@extends('layouts.app')
@section('title', 'Catégories clients')

@section('content')
<div class="page-header">
    <h1 class="page-title">Catégories clients</h1>
    @can('categories.creer')
    <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Nouvelle catégorie</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Remise par défaut</th>
                    <th>Nb clients</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td class="fw-600 text-900">{{ $cat->nom }}</td>
                    <td>
                        <span class="badge badge-accent">{{ $cat->remise_default }} %</span>
                    </td>
                    <td>
                        <span class="badge badge-neutral">{{ $cat->clients_count }}</span>
                    </td>
                    <td class="actions-cell">
                        @can('categories.voir')
                        <a href="{{ route('categories.show', $cat) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('categories.modifier')
                        <a href="{{ route('categories.edit', $cat) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endcan
                        @can('categories.supprimer')
                        <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer cette catégorie ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-state-icon">🏷</div>
                            <div class="empty-state-text">Aucune catégorie.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $categories->links() }}</div>
</div>
@endsection
