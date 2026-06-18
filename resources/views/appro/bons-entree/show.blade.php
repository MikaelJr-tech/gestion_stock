@extends('layouts.app')
@section('title', 'Bon d\'entrée ' . $bonEntree->numero)

@section('content')
<a href="{{ route('appro.bons-entree.index') }}" class="back-link">← Retour aux bons d'entrée</a>

<div class="flex-between mb-16">
    <div></div>
    @can('appro.bons-entree.imprimer')
    <a href="{{ route('appro.bons-entree.imprimer', $bonEntree) }}" target="_blank"
       class="btn btn-success">🖨 Imprimer</a>
    @endcan
</div>

<div class="grid-2 mb-16" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">📥 {{ $bonEntree->numero }}</span>
            @if($bonEntree->type === 'don')
                <span class="badge badge-purple">{{ $bonEntree->type }}</span>
            @elseif($bonEntree->type === 'retour')
                <span class="badge badge-info">{{ $bonEntree->type }}</span>
            @else
                <span class="badge badge-neutral">{{ $bonEntree->type }}</span>
            @endif
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Source / Donateur</span>
                <span class="detail-value">{{ $bonEntree->source ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date d'entrée</span>
                <span class="detail-value">{{ $bonEntree->date_entree->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Enregistré par</span>
                <span class="detail-value">{{ $bonEntree->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Notes</span>
                <span class="detail-value">{{ $bonEntree->notes ?? '—' }}</span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            <div class="flex gap-8">
                @can('appro.bons-entree.modifier')
                <a href="{{ route('appro.bons-entree.edit', $bonEntree) }}" class="btn btn-warning btn-sm">Modifier</a>
                @endcan
                @can('appro.bons-entree.supprimer')
                <form action="{{ route('appro.bons-entree.destroy', $bonEntree) }}" method="POST"
                      onsubmit="return confirm('Supprimer ce bon d\'entrée ? Le stock sera mis à jour.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Produits entrés</span>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Valeur unitaire</th>
                        <th>Valeur totale</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bonEntree->lignes as $ligne)
                    <tr>
                        <td class="fw-500 text-900">{{ $ligne->produit->nom }}</td>
                        <td>{{ $ligne->quantite }} {{ $ligne->produit->unite }}</td>
                        <td>{{ number_format($ligne->valeur_unitaire, 0, ',', ' ') }} FCFA</td>
                        <td class="fw-600 text-accent">
                            {{ number_format($ligne->quantite * $ligne->valeur_unitaire, 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right fw-700">TOTAL :</td>
                        <td class="fw-700 text-accent">
                            {{ number_format($bonEntree->lignes->sum(fn($l) => $l->quantite * $l->valeur_unitaire), 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
