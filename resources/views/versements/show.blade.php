@extends('layouts.app')
@section('title', 'Détail versement')

@section('content')
<a href="{{ route('versements.index') }}" class="back-link">← Retour aux versements</a>

<div style="max-width: 500px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">💰 Détail du versement</span>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Banque</span>
                <span class="detail-value fw-600">{{ $versement->banque->nom }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Montant</span>
                <span class="detail-value fw-700 text-success" style="font-size:18px;">
                    {{ number_format($versement->montant, 0, ',', ' ') }} FCFA
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date de versement</span>
                <span class="detail-value">{{ $versement->date_versement->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Référence</span>
                <span class="detail-value font-mono">{{ $versement->reference ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Enregistré par</span>
                <span class="detail-value">{{ $versement->user->name ?? '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Notes</span>
                <span class="detail-value">{{ $versement->notes ?? '—' }}</span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            <div class="flex gap-8">
                @can('versements.modifier')
                <a href="{{ route('versements.edit', $versement) }}" class="btn btn-warning btn-sm">Modifier</a>
                @endcan
                @can('versements.supprimer')
                <form action="{{ route('versements.destroy', $versement) }}" method="POST"
                      onsubmit="return confirm('Supprimer ce versement ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection