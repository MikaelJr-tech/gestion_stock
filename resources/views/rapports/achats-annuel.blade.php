@extends('layouts.app')
@section('title', 'État des achats annuel')

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
                <label class="form-label">Année</label>
                <select name="annee" class="form-select" style="width:150px;">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $annee == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Achats de l'année {{ $annee }}</span>
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
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr>
                    <td class="font-mono">{{ $commande->numero }}</td>
                    <td class="fw-500 text-900">{{ $commande->fournisseur->nom }}</td>
                    <td class="text-500">{{ $commande->date_commande->format('d/m/Y') }}</td>
                    <td>
                        @if($commande->statut === 'reçu')
                            <span class="badge badge-success">{{ $commande->statut }}</span>
                        @elseif($commande->statut === 'partiel')
                            <span class="badge badge-warning">{{ $commande->statut }}</span>
                        @else
                            <span class="badge badge-neutral">{{ $commande->statut }}</span>
                        @endif
                    </td>
                    <td class="fw-600">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <div class="empty-state-text">Aucun achat pour cette année.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($commandes->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right fw-700">TOTAL :</td>
                    <td class="fw-700 text-accent">{{ number_format($total, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
