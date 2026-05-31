@extends('layouts.app')
@section('title', 'Versements banque')

@section('content')
<div class="page-header">
    <h1 class="page-title">Versements en banque</h1>
    @can('versements.creer')
    <a href="{{ route('versements.create') }}" class="btn btn-primary">+ Nouveau versement</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Banque</th>
                    <th>Montant</th>
                    <th>Référence</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($versements as $versement)
                <tr>
                    <td class="text-500">{{ $versement->date_versement->format('d/m/Y') }}</td>
                    <td class="fw-600 text-900">{{ $versement->banque->nom }}</td>
                    <td class="fw-700 text-success">{{ number_format($versement->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="font-mono text-400">{{ $versement->reference ?? '—' }}</td>
                    <td class="actions-cell">
                        @can('versements.voir')
                        <a href="{{ route('versements.show', $versement) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('versements.modifier')
                        <a href="{{ route('versements.edit', $versement) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endcan
                        @can('versements.supprimer')
                        <form action="{{ route('versements.destroy', $versement) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ce versement ?')">
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
                            <div class="empty-state-icon">💰</div>
                            <div class="empty-state-text">Aucun versement enregistré.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $versements->links() }}</div>
</div>
@endsection
