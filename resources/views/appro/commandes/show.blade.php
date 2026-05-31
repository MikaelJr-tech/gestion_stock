@extends('layouts.app')
@section('title', 'Bon de commande ' . $commande->numero)

@section('content')

<div class="back-link mb-16">
    <a href="{{ route('appro.commandes.index') }}" class="back-link">← Retour aux bons de commande</a>
</div>

<div class="flex-between mb-16">
    <div></div>
    <div class="flex gap-8">
        @can('appro.commandes.imprimer')
        <a href="{{ route('appro.commandes.imprimer', $commande) }}" target="_blank"
           class="btn btn-success">🖨 Imprimer BCF</a>
        <a href="{{ route('appro.commandes.imprimer-reception', $commande) }}" target="_blank"
           class="btn btn-info">🖨 Bon réception</a>
        @endcan
        @can('appro.commandes.modifier')
        <a href="{{ route('appro.commandes.edit', $commande) }}" class="btn btn-warning">✏ Modifier</a>
        @endcan
    </div>
</div>

<div class="grid-2 mb-16" style="align-items: start;">

    {{-- Infos commande --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">📋 {{ $commande->numero }}</span>
            @if($commande->statut === 'reçu')
                <span class="badge badge-success">{{ $commande->statut }}</span>
            @elseif($commande->statut === 'partiel')
                <span class="badge badge-warning">{{ $commande->statut }}</span>
            @elseif($commande->statut === 'annulé')
                <span class="badge badge-danger">{{ $commande->statut }}</span>
            @else
                <span class="badge badge-neutral">{{ $commande->statut }}</span>
            @endif
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Fournisseur</span>
                <span class="detail-value">{{ $commande->fournisseur->nom }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date commande</span>
                <span class="detail-value">{{ $commande->date_commande->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date livraison prévue</span>
                <span class="detail-value">{{ $commande->date_livraison_prevue?->format('d/m/Y') ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Créé par</span>
                <span class="detail-value">{{ $commande->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Montant total</span>
                <span class="detail-value fw-700 text-accent" style="font-size:16px;">
                    {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                </span>
            </div>
            @if($commande->notes)
            <div class="detail-row">
                <span class="detail-label">Notes</span>
                <span class="detail-value">{{ $commande->notes }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Produits commandés --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Produits commandés</span>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Qté commandée</th>
                        <th>Qté reçue</th>
                        <th>Prix unitaire</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->lignes as $ligne)
                    <tr>
                        <td class="fw-500 text-900">{{ $ligne->produit->nom }}</td>
                        <td>{{ $ligne->quantite_commandee }} {{ $ligne->produit->unite }}</td>
                        <td>
                            @if($ligne->quantite_recue >= $ligne->quantite_commandee)
                                <span class="badge badge-success">{{ $ligne->quantite_recue }}</span>
                            @elseif($ligne->quantite_recue > 0)
                                <span class="badge badge-warning">{{ $ligne->quantite_recue }}</span>
                            @else
                                <span class="badge badge-neutral">0</span>
                            @endif
                        </td>
                        <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                        <td class="fw-600">{{ number_format($ligne->montant, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">TOTAL :</td>
                        <td class="fw-700 text-accent">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

{{-- ═══ FORMULAIRE DE RÉCEPTION ═══ --}}
@if($commande->statut !== 'reçu' && $commande->statut !== 'annulé')
@can('appro.commandes.modifier')
<div class="card">
    <div class="card-header">
        <span class="card-title">📦 Enregistrer la réception des produits</span>
        <span class="badge badge-info">Met à jour le stock automatiquement</span>
    </div>
    <div class="card-body">
        <form action="{{ route('appro.commandes.recevoir', $commande) }}" method="POST">
            @csrf

            <div class="table-wrap mb-16">
                <table class="inline-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Unité</th>
                            <th>Qté commandée</th>
                            <th>Stock actuel</th>
                            <th>Qté reçue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commande->lignes as $ligne)
                        <tr>
                            <td class="fw-500 text-900">{{ $ligne->produit->nom }}</td>
                            <td class="text-400">{{ $ligne->produit->unite }}</td>
                            <td>
                                <span class="badge badge-neutral">{{ $ligne->quantite_commandee }}</span>
                            </td>
                            <td>
                                <span class="badge badge-accent">{{ $ligne->produit->stock_actuel }}</span>
                            </td>
                            <td>
                                <input type="number"
                                       name="lignes[{{ $ligne->id }}][quantite_recue]"
                                       value="{{ $ligne->quantite_recue }}"
                                       min="0"
                                       max="{{ $ligne->quantite_commandee }}"
                                       style="width: 100px;"
                                       placeholder="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="info-box mb-16" style="background:#eff6ff; border-color:#bfdbfe;">
                <p style="font-size:12.5px; color:#1d4ed8;">
                    💡 <strong>Comment ça fonctionne :</strong>
                    Saisissez la quantité réellement reçue pour chaque produit.
                    Le stock sera automatiquement mis à jour.
                    Si toutes les quantités sont reçues → statut <strong>"reçu"</strong>.
                    Si partiellement → statut <strong>"partiel"</strong>.
                </p>
            </div>

            <div class="flex gap-8">
                <button type="submit" class="btn btn-primary">
                    ✅ Enregistrer la réception
                </button>
                <button type="button" class="btn btn-secondary"
                        onclick="remplirTout()">
                    ⚡ Tout reçu (quantités complètes)
                </button>
            </div>
        </form>
    </div>
</div>
@endcan
@else
<div class="card">
    <div class="card-body" style="background:#ecfdf5; border-color:#a7f3d0; text-align:center; padding: 20px;">
        <p style="font-size:14px; color:#059669; font-weight:600;">
            ✅ Ce bon de commande a été entièrement reçu. Le stock a été mis à jour.
        </p>
    </div>
</div>
@endif

<script>
function remplirTout() {
    document.querySelectorAll('input[name*="quantite_recue"]').forEach(function(input) {
        input.value = input.getAttribute('max');
    });
}
</script>

@endsection
