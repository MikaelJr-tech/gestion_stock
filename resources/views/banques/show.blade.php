@extends('layouts.app')
@section('title', $banque->nom)

@section('content')
<a href="{{ route('banques.index') }}" class="back-link">← Retour aux banques</a>

<div class="grid-2 mb-20" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">🏦 {{ $banque->nom }}</span>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">N° Compte</span>
                <span class="detail-value font-mono">{{ $banque->numero_compte ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Solde actuel</span>
                <span class="detail-value">
                    <span class="fw-700 text-success" style="font-size:18px;">
                        {{ number_format($banque->solde, 0, ',', ' ') }} FCFA
                    </span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nb versements</span>
                <span class="detail-value">
                    <span class="badge badge-accent">{{ $versements->total() }}</span>
                </span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            <div class="flex gap-8">
                @can('banques.modifier')
                <a href="{{ route('banques.edit', $banque) }}" class="btn btn-warning btn-sm">Modifier</a>
                @endcan
                @can('versements.creer')
                <a href="{{ route('versements.create') }}" class="btn btn-success btn-sm">+ Versement</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Historique des versements</span>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Référence</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($versements as $versement)
                    <tr>
                        <td class="text-500">{{ $versement->date_versement->format('d/m/Y') }}</td>
                        <td class="font-mono text-400">{{ $versement->reference ?? '—' }}</td>
                        <td class="fw-700 text-success">{{ number_format($versement->montant, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <div class="empty-state-icon">💰</div>
                                <div class="empty-state-text">Aucun versement.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 8px 16px;">{{ $versements->links() }}</div>
    </div>
</div>
@endsection