@extends('layouts.app')
@section('title', 'Commande ' . $commande->numero)

@section('content')
<a href="{{ route('ventes.commandes.index') }}" class="back-link">← Retour aux commandes</a>

<div class="flex-between mb-16">
    <div></div>
    <div class="flex gap-8">
        @if($commande->statut === 'en_attente')
        @can('ventes.commandes.livrer')
        <form action="{{ route('ventes.commandes.livrer', $commande) }}" method="POST"
              onsubmit="return confirm('Confirmer la livraison ?')">
            @csrf
            <button type="submit" class="btn btn-success">✅ Livrer</button>
        </form>
        @endcan
        @endif
        @can('ventes.commandes.imprimer')
        <a href="{{ route('ventes.commandes.imprimer', $commande) }}" target="_blank"
           class="btn btn-info">🖨 Bon commande</a>
        <a href="{{ route('ventes.commandes.imprimer-livraison', $commande) }}" target="_blank"
           class="btn btn-secondary">🖨 Bon livraison</a>
        @endcan
        @can('ventes.commandes.modifier')
        <a href="{{ route('ventes.commandes.edit', $commande) }}" class="btn btn-warning">✏ Modifier</a>
        @endcan
    </div>
</div>

<div class="grid-2 mb-16" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">🛒 {{ $commande->numero }}</span>
            @if($commande->statut === 'livrée')
                <span class="badge badge-success">{{ $commande->statut }}</span>
            @elseif($commande->statut === 'en_attente')
                <span class="badge badge-warning">{{ $commande->statut }}</span>
            @elseif($commande->statut === 'annulée')
                <span class="badge badge-danger">{{ $commande->statut }}</span>
            @else
                <span class="badge badge-info">{{ $commande->statut }}</span>
            @endif
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Client</span>
                <span class="detail-value fw-600">{{ $commande->client->nom }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date commande</span>
                <span class="detail-value">{{ $commande->date_commande->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Créé par</span>
                <span class="detail-value">{{ $commande->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Montant total</span>
                <span class="detail-value fw-700 text-accent" style="font-size:18px;">
                    {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Produits commandés</span>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Qté</th>
                        <th>Prix unit.</th>
                        <th>Remise</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->lignes as $ligne)
                    <tr>
                        <td class="fw-500 text-900">{{ $ligne->produit->nom }}</td>
                        <td>{{ $ligne->quantite }} {{ $ligne->produit->unite }}</td>
                        <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }}</td>
                        <td>
                            @if($ligne->remise > 0)
                                <span class="badge badge-warning">{{ $ligne->remise }} %</span>
                            @else
                                <span class="text-400">—</span>
                            @endif
                        </td>
                        <td class="fw-600 text-accent">{{ number_format($ligne->montant, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right fw-700">TOTAL :</td>
                        <td class="fw-700 text-accent">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
