@extends('layouts.app')
@section('title', 'Produits')

@section('content')
<div class="page-header">
    <h1 class="page-title">Produits</h1>
    @can('produits.creer')
    <a href="{{ route('produits.create') }}" class="btn btn-primary">+ Nouveau produit</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Famille</th>
                    <th>Stock</th>
                    <th>Prix achat</th>
                    <th>Prix vente</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produits as $produit)
                <tr>
                    <td class="font-mono text-400">{{ $produit->code }}</td>
                    <td class="fw-600 text-900">{{ $produit->nom }}</td>
                    <td class="text-500">{{ $produit->famille->nom ?? '—' }}</td>
                    <td>
                        @if($produit->estEnRuptureDeStock())
                            <span class="badge badge-danger">{{ $produit->stock_actuel }} {{ $produit->unite }}</span>
                        @else
                            <span class="badge badge-success">{{ $produit->stock_actuel }} {{ $produit->unite }}</span>
                        @endif
                    </td>
                    <td class="text-700">{{ number_format($produit->prix_achat, 0, ',', ' ') }}</td>
                    <td class="fw-500 text-accent">{{ number_format($produit->prix_vente, 0, ',', ' ') }}</td>
                    <td><span class="badge badge-neutral">{{ $produit->type }}</span></td>
                    <td class="actions-cell">
                        @can('produits.voir')
                        <a href="{{ route('produits.show', $produit) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('produits.modifier')
                        <a href="{{ route('produits.edit', $produit) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endcan
                        @can('produits.supprimer')
                        <form action="{{ route('produits.destroy', $produit) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ce produit ?')">
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
                            <div class="empty-state-icon">📦</div>
                            <div class="empty-state-text">Aucun produit enregistré.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $produits->links() }}</div>
</div>
@endsection
