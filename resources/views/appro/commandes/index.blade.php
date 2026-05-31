@extends('layouts.app')
@section('title', 'Bons de commande fournisseur')

@section('content')
<div class="page-header">
    <h1 class="page-title">Bons de commande fournisseur</h1>
    @can('appro.commandes.creer')
    <a href="{{ route('appro.commandes.create') }}" class="btn btn-primary">+ Nouveau bon de commande</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Fournisseur</th>
                    <th>Date commande</th>
                    <th>Date livraison</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr>
                    <td class="font-mono fw-600 text-900">{{ $commande->numero }}</td>
                    <td class="fw-500">{{ $commande->fournisseur->nom }}</td>
                    <td class="text-500">{{ $commande->date_commande->format('d/m/Y') }}</td>
                    <td class="text-400">{{ $commande->date_livraison_prevue?->format('d/m/Y') ?? '—' }}</td>
                    <td class="fw-600 text-900">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($commande->statut === 'reçu')
                            <span class="badge badge-success">{{ $commande->statut }}</span>
                        @elseif($commande->statut === 'partiel')
                            <span class="badge badge-warning">{{ $commande->statut }}</span>
                        @elseif($commande->statut === 'annulé')
                            <span class="badge badge-danger">{{ $commande->statut }}</span>
                        @else
                            <span class="badge badge-neutral">{{ $commande->statut }}</span>
                        @endif
                    </td>
                    <td class="actions-cell">
                        @can('appro.commandes.voir')
                        <a href="{{ route('appro.commandes.show', $commande) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('appro.commandes.modifier')
                        <a href="{{ route('appro.commandes.edit', $commande) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endcan
                        @can('appro.commandes.imprimer')
                        <a href="{{ route('appro.commandes.imprimer', $commande) }}" target="_blank" class="btn btn-success btn-sm">PDF</a>
                        @endcan
                        @can('appro.commandes.supprimer')
                        <form action="{{ route('appro.commandes.destroy', $commande) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ce bon de commande ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <div class="empty-state-text">Aucun bon de commande enregistré.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $commandes->links() }}</div>
</div>
@endsection
