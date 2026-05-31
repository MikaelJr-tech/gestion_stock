@extends('layouts.app')
@section('title', 'État des achats')

@section('content')

{{-- Onglets --}}
<div class="flex gap-8 mb-16">
    <a href="{{ route('rapports.achats-jour') }}"
       class="btn {{ request()->routeIs('rapports.achats-jour') ? 'btn-primary' : 'btn-secondary' }}">
        📅 Par jour
    </a>
    <a href="{{ route('rapports.achats-annuel') }}"
       class="btn {{ request()->routeIs('rapports.achats-annuel') ? 'btn-primary' : 'btn-secondary' }}">
        📆 Annuel
    </a>
</div>

<div class="card mb-16">
    <div class="card-body">
        <form method="GET" class="flex gap-8" style="align-items: flex-end;">
            <div class="form-group mb-0">
                <label class="form-label">Date</label>
                <input type="date" name="date" value="{{ $date }}" class="form-input" style="width:200px;">
            </div>
            <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
            <a href="{{ route('rapports.imprimer-achats-jour', ['date' => $date]) }}"
               target="_blank" class="btn btn-success">🖨 Imprimer</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Achats du {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
        <span class="fw-700 text-accent" style="font-size:15px;">
            Total : {{ number_format($total, 0, ',', ' ') }} FCFA
        </span>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Numéro BCF</th>
                    <th>Fournisseur</th>
                    <th>Statut</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr>
                    <td class="font-mono">{{ $commande->numero }}</td>
                    <td class="fw-500 text-900">{{ $commande->fournisseur->nom }}</td>
                    <td>
                        @if($commande->statut === 'reçu')
                            <span class="badge badge-success">{{ $commande->statut }}</span>
                        @elseif($commande->statut === 'partiel')
                            <span class="badge badge-warning">{{ $commande->statut }}</span>
                        @elseif($commande->statut === 'annulé')
                            <span class="badge badge-danger">{{ $commande->statut }}</span>
                        @else
                            <span class="badge badge-neutral">{{ $commande->statut }}</span>
                        @endif
                    </td>
                    <td class="fw-600 text-900">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <div class="empty-state-text">Aucun achat pour cette date.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($commandes->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right fw-700">TOTAL :</td>
                    <td class="fw-700 text-accent">{{ number_format($total, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
