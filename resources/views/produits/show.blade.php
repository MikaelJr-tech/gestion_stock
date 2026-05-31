@extends('layouts.app')
@section('title', $produit->nom)

@section('content')
<a href="{{ route('produits.index') }}" class="back-link">← Retour aux produits</a>

<div class="grid-2 mb-20" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">{{ $produit->nom }}</span>
            <span class="badge badge-neutral">{{ $produit->type }}</span>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Code</span>
                <span class="detail-value font-mono">{{ $produit->code }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Famille</span>
                <span class="detail-value">{{ $produit->famille->nom ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Unité</span>
                <span class="detail-value">{{ $produit->unite }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Prix achat</span>
                <span class="detail-value">{{ number_format($produit->prix_achat, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Prix vente</span>
                <span class="detail-value fw-600 text-accent">{{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Stock actuel</span>
                <span class="detail-value">
                    @if($produit->estEnRuptureDeStock())
                        <span class="badge badge-danger">{{ $produit->stock_actuel }} {{ $produit->unite }}</span>
                    @else
                        <span class="badge badge-success">{{ $produit->stock_actuel }} {{ $produit->unite }}</span>
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Stock minimum</span>
                <span class="detail-value">{{ $produit->stock_minimum }}</span>
            </div>
            @if($produit->date_expiration)
            <div class="detail-row">
                <span class="detail-label">Date expiration</span>
                <span class="detail-value">{{ $produit->date_expiration->format('d/m/Y') }}</span>
            </div>
            @endif
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            <div class="flex gap-8">
                @can('produits.modifier')
                <a href="{{ route('produits.edit', $produit) }}" class="btn btn-warning btn-sm">Modifier</a>
                @endcan
                @if($produit->type === 'père')
                @can('produits.voir')
                <a href="{{ route('produits.fractionner', $produit) }}" class="btn btn-info btn-sm">Fractionner</a>
                @endcan
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Produits fils</span>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Stock</th>
                        <th>Prix vente</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produit->produitsFils as $fils)
                    <tr>
                        <td class="fw-500 text-900">{{ $fils->nom }}</td>
                        <td>
                            @if($fils->estEnRuptureDeStock())
                                <span class="badge badge-danger">{{ $fils->stock_actuel }}</span>
                            @else
                                <span class="badge badge-success">{{ $fils->stock_actuel }}</span>
                            @endif
                        </td>
                        <td class="text-accent fw-500">{{ number_format($fils->prix_vente, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <div class="empty-state-icon">📦</div>
                                <div class="empty-state-text">Aucun produit fils.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
