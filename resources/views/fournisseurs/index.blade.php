@extends('layouts.app')
@section('title', 'Fournisseurs')

@section('content')
<div class="page-header">
    <h1 class="page-title">Fournisseurs</h1>
    @can('fournisseurs.creer')
    <a href="{{ route('fournisseurs.create') }}" class="btn btn-primary">+ Nouveau fournisseur</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>N° Contribuable</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fournisseurs as $fournisseur)
                <tr>
                    <td class="fw-600 text-900">{{ $fournisseur->nom }}</td>
                    <td class="text-500">{{ $fournisseur->telephone ?? '—' }}</td>
                    <td class="text-500">{{ $fournisseur->email ?? '—' }}</td>
                    <td class="font-mono text-400">{{ $fournisseur->numero_contribuable ?? '—' }}</td>
                    <td class="actions-cell">
                        @can('fournisseurs.voir')
                        <a href="{{ route('fournisseurs.show', $fournisseur) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('fournisseurs.modifier')
                        <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endcan
                        @can('fournisseurs.supprimer')
                        <form action="{{ route('fournisseurs.destroy', $fournisseur) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ce fournisseur ?')">
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
                            <div class="empty-state-icon">🏭</div>
                            <div class="empty-state-text">Aucun fournisseur enregistré.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $fournisseurs->links() }}</div>
</div>
@endsection
