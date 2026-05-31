@extends('layouts.app')
@section('title', 'Factures fournisseur')

@section('content')
<div class="page-header">
    <h1 class="page-title">Factures fournisseur</h1>
    @can('appro.factures.creer')
    <a href="{{ route('appro.factures.create') }}" class="btn btn-primary">+ Nouvelle facture</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Fournisseur</th>
                    <th>Date</th>
                    <th>Montant TTC</th>
                    <th>Réglé</th>
                    <th>Reste</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($factures as $facture)
                <tr>
                    <td class="font-mono fw-600 text-900">{{ $facture->numero }}</td>
                    <td class="fw-500">{{ $facture->fournisseur->nom }}</td>
                    <td class="text-500">{{ $facture->date_facture->format('d/m/Y') }}</td>
                    <td class="fw-600 text-900">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td>
                    <td class="text-success fw-500">{{ number_format($facture->montant_regle, 0, ',', ' ') }} FCFA</td>
                    <td class="text-danger fw-600">{{ number_format($facture->resteAPayer(), 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($facture->statut === 'réglée')
                            <span class="badge badge-success">{{ $facture->statut }}</span>
                        @elseif($facture->statut === 'partielle')
                            <span class="badge badge-warning">{{ $facture->statut }}</span>
                        @else
                            <span class="badge badge-danger">{{ $facture->statut }}</span>
                        @endif
                    </td>
                    <td class="actions-cell">
                        @can('appro.factures.voir')
                        <a href="{{ route('appro.factures.show', $facture) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('appro.factures.imprimer')
                        <a href="{{ route('appro.factures.imprimer', $facture) }}" target="_blank" class="btn btn-success btn-sm">PDF</a>
                        @endcan
                        @can('appro.factures.supprimer')
                        <form action="{{ route('appro.factures.destroy', $facture) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">🧾</div>
                            <div class="empty-state-text">Aucune facture fournisseur.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $factures->links() }}</div>
</div>
@endsection
