@extends('layouts.app')
@section('title', 'État des ventes annuel')

@section('content')

<div class="flex gap-8 mb-16">
    <a href="{{ route('rapports.ventes-jour') }}"
       class="btn {{ request()->routeIs('rapports.ventes-jour') ? 'btn-primary' : 'btn-secondary' }}">
        📅 Par jour
    </a>
    <a href="{{ route('rapports.ventes-annuel') }}"
       class="btn {{ request()->routeIs('rapports.ventes-annuel') ? 'btn-primary' : 'btn-secondary' }}">
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
        <span class="card-title">Ventes de l'année {{ $annee }}</span>
        <span class="fw-700 text-success" style="font-size:15px;">
            Total : {{ number_format($total, 0, ',', ' ') }} FCFA
        </span>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Montant TTC</th>
                </tr>
            </thead>
            <tbody>
                @forelse($factures as $facture)
                <tr>
                    <td class="font-mono">{{ $facture->numero }}</td>
                    <td class="fw-500 text-900">{{ $facture->client->nom }}</td>
                    <td class="text-500">{{ $facture->date_facture->format('d/m/Y') }}</td>
                    <td><span class="badge badge-accent">{{ $facture->type_vente }}</span></td>
                    <td>
                        @if($facture->statut === 'réglée')
                            <span class="badge badge-success">{{ $facture->statut }}</span>
                        @elseif($facture->statut === 'partielle')
                            <span class="badge badge-warning">{{ $facture->statut }}</span>
                        @else
                            <span class="badge badge-danger">{{ $facture->statut }}</span>
                        @endif
                    </td>
                    <td class="fw-600">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">🧾</div>
                            <div class="empty-state-text">Aucune vente pour cette année.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($factures->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right fw-700">TOTAL :</td>
                    <td class="fw-700 text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
