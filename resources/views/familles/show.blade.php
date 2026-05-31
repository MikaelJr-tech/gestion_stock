@extends('layouts.app')
@section('title', 'Famille : ' . $famille->nom)

@section('content')
<a href="{{ route('familles.index') }}" class="back-link">← Retour aux familles</a>

<div class="page-header mb-20">
    <h1 class="page-title">{{ $famille->nom }}</h1>
    @can('familles.modifier')
    <a href="{{ route('familles.edit', $famille) }}" class="btn btn-warning">Modifier</a>
    @endcan
</div>

<div class="grid-2 mb-20" style="align-items: start;">
    <div class="card">
        <div class="card-header"><span class="card-title">Informations</span></div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Nom</span>
                <span class="detail-value">{{ $famille->nom }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Description</span>
                <span class="detail-value">{{ $famille->description ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nombre de produits</span>
                <span class="detail-value">
                    <span class="badge badge-accent">{{ $produits->total() }}</span>
                </span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Produits de cette famille</span>
            @can('produits.creer')
            <a href="{{ route('produits.create') }}" class="btn btn-primary btn-sm">+ Ajouter</a>
            @endcan
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Stock</th>
                        <th>Prix vente</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produits as $produit)
                    <tr>
                        <td class="font-mono text-400">{{ $produit->code }}</td>
                        <td class="fw-500 text-900">{{ $produit->nom }}</td>
                        <td>
                            @if($produit->estEnRuptureDeStock())
                                <span class="badge badge-danger">{{ $produit->stock_actuel }} {{ $produit->unite }}</span>
                            @else
                                <span class="badge badge-success">{{ $produit->stock_actuel }} {{ $produit->unite }}</span>
                            @endif
                        </td>
                        <td class="fw-500 text-accent">{{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-state-icon">📦</div>
                                <div class="empty-state-text">Aucun produit dans cette famille.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 8px 16px;">{{ $produits->links() }}</div>
    </div>
</div>
@endsection
