@extends('layouts.app')
@section('title', 'Banques')

@section('content')
<div class="page-header">
    <h1 class="page-title">Banques</h1>
    @can('banques.creer')
    <a href="{{ route('banques.create') }}" class="btn btn-primary">+ Nouvelle banque</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>N° Compte</th>
                    <th>Solde</th>
                    <th>Versements</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banques as $banque)
                <tr>
                    <td class="fw-600 text-900">{{ $banque->nom }}</td>
                    <td class="font-mono text-400">{{ $banque->numero_compte ?? '—' }}</td>
                    <td>
                        <span class="fw-700 text-success">{{ number_format($banque->solde, 0, ',', ' ') }} FCFA</span>
                    </td>
                    <td>
                        <span class="badge badge-accent">{{ $banque->versements_count }}</span>
                    </td>
                    <td class="actions-cell">
                        @can('banques.voir')
                        <a href="{{ route('banques.show', $banque) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('banques.modifier')
                        <a href="{{ route('banques.edit', $banque) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endcan
                        @can('banques.supprimer')
                        <form action="{{ route('banques.destroy', $banque) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer cette banque ?')">
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
                            <div class="empty-state-icon">🏦</div>
                            <div class="empty-state-text">Aucune banque enregistrée.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $banques->links() }}</div>
</div>
@endsection
