@extends('layouts.app')
@section('title', 'Bon de sortie ' . $bonSortie->numero)

@section('content')
<a href="{{ route('ventes.bons-sortie.index') }}" class="back-link">← Retour aux bons de sortie</a>

<div class="flex-between mb-16">
    <div></div>
    @can('ventes.bons-sortie.imprimer')
    <a href="{{ route('ventes.bons-sortie.imprimer', $bonSortie) }}" target="_blank"
       class="btn btn-success">🖨 Imprimer</a>
    @endcan
</div>

<div class="grid-2 mb-16" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">📤 {{ $bonSortie->numero }}</span>
            @if($bonSortie->motif === 'périmé')
                <span class="badge badge-danger">{{ $bonSortie->motif }}</span>
            @elseif($bonSortie->motif === 'casse')
                <span class="badge badge-warning">{{ $bonSortie->motif }}</span>
            @else
                <span class="badge badge-neutral">{{ $bonSortie->motif }}</span>
            @endif
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Date de sortie</span>
                <span class="detail-value">{{ $bonSortie->date_sortie->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Enregistré par</span>
                <span class="detail-value">{{ $bonSortie->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Notes</span>
                <span class="detail-value">{{ $bonSortie->notes ?? '—' }}</span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            <div class="flex gap-8">
                @can('ventes.bons-sortie.modifier')
                <a href="{{ route('ventes.bons-sortie.edit', $bonSortie) }}" class="btn btn-warning btn-sm">Modifier</a>
                @endcan
                @can('ventes.bons-sortie.supprimer')
                <form action="{{ route('ventes.bons-sortie.destroy', $bonSortie) }}" method="POST"
                      onsubmit="return confirm('Supprimer ? Le stock sera restauré.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Produits sortis</span>
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
                    @foreach($bonSortie->lignes as $ligne)
                    <tr>
                        <td class="fw-500 text-900">{{ $ligne->produit->nom }}</td>
                        <td>{{ $ligne->quantite }} {{ $ligne->produit->unite }}</td>
                        <td>{{ number_format($ligne->valeur_unitaire, 0, ',', ' ') }} FCFA</td>
                        <td class="fw-600 text-danger">
                            {{ number_format($ligne->quantite * $ligne->valeur_unitaire, 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right fw-700">TOTAL PERTE :</td>
                        <td class="fw-700 text-danger">
                            {{ number_format($bonSortie->lignes->sum(fn($l) => $l->quantite * $l->valeur_unitaire), 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
