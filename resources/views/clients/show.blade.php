@extends('layouts.app')
@section('title', $client->nom)

@section('content')
<a href="{{ route('clients.index') }}" class="back-link">← Retour aux clients</a>

<div class="grid-2 mb-20" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">{{ $client->nom }}</span>
            <span class="badge badge-neutral">{{ $client->categorie->nom ?? '—' }}</span>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Téléphone</span>
                <span class="detail-value">{{ $client->telephone ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $client->email ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Adresse</span>
                <span class="detail-value">{{ $client->adresse ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Solde</span>
                <span class="detail-value">
                    @if($client->solde < 0)
                        <span class="badge badge-danger">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</span>
                    @elseif($client->solde > 0)
                        <span class="badge badge-success">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</span>
                    @else
                        <span class="badge badge-neutral">0 FCFA</span>
                    @endif
                </span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            @can('clients.modifier')
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">Modifier</a>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Dernières commandes</span>
            @can('ventes.commandes.voir')
            <a href="{{ route('ventes.commandes.index') }}" class="btn btn-secondary btn-sm">Voir tout</a>
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
                    @forelse($client->commandes->take(5) as $commande)
                    <tr>
                        <td class="font-mono text-400">{{ $commande->numero }}</td>
                        <td class="text-500">{{ $commande->date_commande->format('d/m/Y') }}</td>
                        <td class="fw-600 text-accent">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                        <td>
                            @if($commande->statut === 'livrée')
                                <span class="badge badge-success">{{ $commande->statut }}</span>
                            @elseif($commande->statut === 'en_attente')
                                <span class="badge badge-warning">{{ $commande->statut }}</span>
                            @else
                                <span class="badge badge-danger">{{ $commande->statut }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-state-icon">🛒</div>
                                <div class="empty-state-text">Aucune commande.</div>
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