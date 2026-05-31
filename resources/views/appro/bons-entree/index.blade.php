@extends('layouts.app')
@section('title', 'Bons d\'entrée / Dons')

@section('content')
<div class="page-header">
    <h1 class="page-title">Bons d'entrée / Dons</h1>
    @can('appro.bons-entree.creer')
    <a href="{{ route('appro.bons-entree.create') }}" class="btn btn-primary">+ Nouveau bon d'entrée</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Type</th>
                    <th>Source</th>
                    <th>Date</th>
                    <th>Créé par</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bons as $bon)
                <tr>
                    <td class="font-mono fw-600 text-900">{{ $bon->numero }}</td>
                    <td>
                        @if($bon->type === 'don')
                            <span class="badge badge-purple">{{ $bon->type }}</span>
                        @elseif($bon->type === 'retour')
                            <span class="badge badge-info">{{ $bon->type }}</span>
                        @else
                            <span class="badge badge-neutral">{{ $bon->type }}</span>
                        @endif
                    </td>
                    <td class="text-500">{{ $bon->source ?? '—' }}</td>
                    <td class="text-500">{{ $bon->date_entree->format('d/m/Y') }}</td>
                    <td class="text-500">{{ $bon->user->name }}</td>
                    <td class="actions-cell">
                        @can('appro.bons-entree.voir')
                        <a href="{{ route('appro.bons-entree.show', $bon) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('appro.bons-entree.imprimer')
                        <a href="{{ route('appro.bons-entree.imprimer', $bon) }}" target="_blank" class="btn btn-success btn-sm">PDF</a>
                        @endcan
                        @can('appro.bons-entree.supprimer')
                        <form action="{{ route('appro.bons-entree.destroy', $bon) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ce bon d\'entrée ? Le stock sera mis à jour.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">📥</div>
                            <div class="empty-state-text">Aucun bon d'entrée.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $bons->links() }}</div>
</div>
@endsection
