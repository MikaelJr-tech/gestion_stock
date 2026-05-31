@extends('layouts.app')
@section('title', 'Commandes clients')

@section('content')
<div class="page-header">
    <h1 class="page-title">Commandes clients</h1>
    @can('ventes.commandes.creer')
    <a href="{{ route('ventes.commandes.create') }}" class="btn btn-primary">+ Nouvelle commande</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr>
                    <td class="font-mono fw-600 text-900">{{ $commande->numero }}</td>
                    <td class="fw-500">{{ $commande->client->nom }}</td>
                    <td class="text-500">{{ $commande->date_commande->format('d/m/Y') }}</td>
                    <td class="fw-600 text-accent">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($commande->statut === 'livrée')
                            <span class="badge badge-success">{{ $commande->statut }}</span>
                        @elseif($commande->statut === 'en_attente')
                            <span class="badge badge-warning">{{ $commande->statut }}</span>
                        @elseif($commande->statut === 'annulée')
                            <span class="badge badge-danger">{{ $commande->statut }}</span>
                        @else
                            <span class="badge badge-info">{{ $commande->statut }}</span>
                        @endif
                    </td>
                    <td class="actions-cell">
                        @can('ventes.commandes.voir')
                        <a href="{{ route('ventes.commandes.show', $commande) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @if($commande->statut === 'en_attente')
                        @can('ventes.commandes.livrer')
                        <form action="{{ route('ventes.commandes.livrer', $commande) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Confirmer la livraison ?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Livrer</button>
                        </form>
                        @endcan
                        @endif
                        @can('ventes.commandes.imprimer')
                        <a href="{{ route('ventes.commandes.imprimer', $commande) }}" target="_blank" class="btn btn-info btn-sm">PDF</a>
                        @endcan
                        @can('ventes.commandes.supprimer')
                        <form action="{{ route('ventes.commandes.destroy', $commande) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ?')">
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
                            <div class="empty-state-icon">🛒</div>
                            <div class="empty-state-text">Aucune commande enregistrée.</div>
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
