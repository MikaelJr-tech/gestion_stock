@extends('layouts.app')
@section('title', $fournisseur->nom)

@section('content')
<a href="{{ route('fournisseurs.index') }}" class="back-link">← Retour aux fournisseurs</a>

<div class="grid-2 mb-20" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">🏭 {{ $fournisseur->nom }}</span>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Téléphone</span>
                <span class="detail-value">{{ $fournisseur->telephone ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $fournisseur->email ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Adresse</span>
                <span class="detail-value">{{ $fournisseur->adresse ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">N° Contribuable</span>
                <span class="detail-value font-mono">{{ $fournisseur->numero_contribuable ?? '—' }}</span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            @can('fournisseurs.modifier')
            <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="btn btn-warning btn-sm">Modifier</a>
            @endcan
        </div>
    </div>

    <div class="flex flex-col gap-16">

        <div class="card">
            <div class="card-header">
                <span class="card-title">Derniers bons de commande</span>
                @can('appro.commandes.creer')
                <a href="{{ route('appro.commandes.create') }}" class="btn btn-primary btn-sm">+ Nouveau</a>
                @endcan
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fournisseur->bonsCommande->take(4) as $bc)
                        <tr>
                            <td class="font-mono text-400">{{ $bc->numero }}</td>
                            <td class="text-500">{{ $bc->date_commande->format('d/m/Y') }}</td>
                            <td class="fw-600 text-900">{{ number_format($bc->montant_total, 0, ',', ' ') }} FCFA</td>
                            <td>
                                @if($bc->statut === 'reçu')
                                    <span class="badge badge-success">{{ $bc->statut }}</span>
                                @elseif($bc->statut === 'partiel')
                                    <span class="badge badge-warning">{{ $bc->statut }}</span>
                                @else
                                    <span class="badge badge-neutral">{{ $bc->statut }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state" style="padding: 20px;">
                                    <div class="empty-state-text">Aucune commande.</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span class="card-title">Dernières factures</span>
                @can('appro.factures.creer')
                <a href="{{ route('appro.factures.create') }}" class="btn btn-primary btn-sm">+ Nouvelle</a>
                @endcan
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                            <th>Montant TTC</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fournisseur->factures->take(4) as $facture)
                        <tr>
                            <td class="font-mono text-400">{{ $facture->numero }}</td>
                            <td class="text-500">{{ $facture->date_facture->format('d/m/Y') }}</td>
                            <td class="fw-600 text-900">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td>
                            <td>
                                @if($facture->statut === 'réglée')
                                    <span class="badge badge-success">{{ $facture->statut }}</span>
                                @elseif($facture->statut === 'partielle')
                                    <span class="badge badge-warning">{{ $facture->statut }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $facture->statut }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state" style="padding: 20px;">
                                    <div class="empty-state-text">Aucune facture.</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection