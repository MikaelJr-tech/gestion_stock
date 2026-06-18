@extends('layouts.app')
@section('title', 'Facture ' . $facture->numero)

@section('content')
<a href="{{ route('ventes.factures.index') }}" class="back-link">← Retour aux factures</a>

<div class="flex-between mb-16">
    <div></div>
    <div class="flex gap-8">
        @can('ventes.factures.imprimer')
        <a href="{{ route('ventes.factures.imprimer', $facture) }}" target="_blank"
           class="btn btn-success">🖨 Imprimer</a>
        @endcan
        @can('ventes.factures.modifier')
        <a href="{{ route('ventes.factures.edit', $facture) }}" class="btn btn-warning">✏ Modifier</a>
        @endcan
    </div>
</div>

<div class="grid-2 mb-16" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">{{ $facture->numero }}</span>
            @if($facture->statut === 'réglée')
                <span class="badge badge-success">{{ $facture->statut }}</span>
            @elseif($facture->statut === 'partielle')
                <span class="badge badge-warning">{{ $facture->statut }}</span>
            @else
                <span class="badge badge-danger">{{ $facture->statut }}</span>
            @endif
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Client</span>
                <span class="detail-value fw-600">{{ $facture->client->nom }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date facture</span>
                <span class="detail-value">{{ $facture->date_facture->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Type vente</span>
                <span class="detail-value">
                    <span class="badge badge-accent">{{ $facture->type_vente }}</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Montant HT</span>
                <span class="detail-value">{{ number_format($facture->montant_ht, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">TVA</span>
                <span class="detail-value">{{ $facture->tva }} %</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Montant TTC</span>
                <span class="detail-value fw-700 text-accent" style="font-size:16px;">
                    {{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Réglé</span>
                <span class="detail-value fw-600 text-success">
                    {{ number_format($facture->montant_regle, 0, ',', ' ') }} FCFA
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Reste à payer</span>
                <span class="detail-value fw-700 text-danger" style="font-size:16px;">
                    {{ number_format($facture->resteAPayer(), 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>

        @if($facture->resteAPayer() > 0)
        @can('ventes.factures.regler')
        <div class="card-body" style="border-top: 1px solid var(--border);">
            <div class="regler-box">
                <p class="fw-600 text-success mb-8" style="font-size:13px;">💳 Enregistrer un règlement</p>
                <form action="{{ route('ventes.factures.regler', $facture) }}" method="POST">
                    @csrf
                    <div class="flex gap-8" style="align-items: flex-end;">
                        <div style="flex:1;">
                            <label class="form-label">Montant à régler</label>
                            <input type="number" name="montant_regle"
                                   step="0.01" min="0.01" max="{{ $facture->resteAPayer() }}"
                                   placeholder="0" class="form-input">
                        </div>
                        <button type="submit" class="btn btn-success">✅ Régler</button>
                    </div>
                </form>
            </div>
        </div>
        @endcan
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Produits facturés</span>
        </div>
        @if($facture->commande)
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
                    @foreach($facture->commande->lignes as $ligne)
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
                        <td colspan="4" class="text-right fw-700">TOTAL HT :</td>
                        <td class="fw-700 text-accent">{{ number_format($facture->montant_ht, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">🧾</div>
            <div class="empty-state-text">Vente comptant directe — pas de commande liée.</div>
        </div>
        @endif
    </div>
</div>
@endsection
