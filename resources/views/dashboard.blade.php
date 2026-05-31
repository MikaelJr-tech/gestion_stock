@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="stats-grid mb-24">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#eff6ff;">📦</div>
        </div>
        <div class="stat-label">Total produits</div>
        <div class="stat-value">{{ $stats['total_produits'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#fef2f2;">⚠️</div>
        </div>
        <div class="stat-label">Ruptures de stock</div>
        <div class="stat-value text-danger">{{ $stats['produits_rupture'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#fffbeb;">🛒</div>
        </div>
        <div class="stat-label">Commandes en attente</div>
        <div class="stat-value text-warning">{{ $stats['commandes_en_attente'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#ecfdf5;">🧾</div>
        </div>
        <div class="stat-label">Factures client impayées</div>
        <div class="stat-value text-success">{{ $stats['factures_impayees'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#f5f3ff;">🏭</div>
        </div>
        <div class="stat-label">Factures fourn. impayées</div>
        <div class="stat-value text-purple">{{ $stats['factures_fournisseur'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#ecfeff;">📋</div>
        </div>
        <div class="stat-label">Commandes fourn. att.</div>
        <div class="stat-value text-accent">{{ $stats['commandes_fournisseur'] }}</div>
    </div>
</div>

<div class="grid-2">

    <div class="card">
        <div class="card-header">
            <span class="card-title">⚠️ Produits en rupture de stock</span>
            @can('produits.voir')
            <a href="{{ route('produits.index') }}" class="btn btn-secondary btn-sm">Voir tout →</a>
            @endcan
        </div>
        @if($produitsRupture->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">✅</div>
            <div class="empty-state-text">Aucun produit en rupture</div>
        </div>
        @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Stock actuel</th>
                        <th>Stock min.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produitsRupture as $produit)
                    <tr>
                        <td class="fw-500 text-900">{{ $produit->nom }}</td>
                        <td><span class="badge badge-danger">{{ $produit->stock_actuel }} {{ $produit->unite }}</span></td>
                        <td class="text-400">{{ $produit->stock_minimum }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">🛒 Dernières commandes clients</span>
            @can('ventes.commandes.voir')
            <a href="{{ route('ventes.commandes.index') }}" class="btn btn-secondary btn-sm">Voir tout →</a>
            @endcan
        </div>
        @if($dernieresCommandes->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🛒</div>
            <div class="empty-state-text">Aucune commande enregistrée</div>
        </div>
        @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dernieresCommandes as $commande)
                    <tr>
                        <td class="font-mono text-400">{{ $commande->numero }}</td>
                        <td class="fw-500 text-900">{{ $commande->client->nom }}</td>
                        <td class="fw-600 text-accent">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</td>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
