@extends('layouts.app')
@section('title', $category->nom)

@section('content')
<a href="{{ route('categories.index') }}" class="back-link">← Retour aux catégories</a>

<div class="grid-2 mb-20" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">🏷 {{ $category->nom }}</span>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Remise par défaut</span>
                <span class="detail-value">
                    <span class="badge badge-accent">{{ $category->remise_default }} %</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nombre de clients</span>
                <span class="detail-value fw-600">{{ $clients->total() }}</span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            @can('categories.modifier')
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Modifier</a>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Clients de cette catégorie</span>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>Solde</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td class="fw-500 text-900">{{ $client->nom }}</td>
                        <td class="text-500">{{ $client->telephone ?? '—' }}</td>
                        <td>
                            @if($client->solde < 0)
                                <span class="badge badge-danger">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</span>
                            @else
                                <span class="badge badge-success">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <div class="empty-state-icon">👥</div>
                                <div class="empty-state-text">Aucun client dans cette catégorie.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 8px 16px;">{{ $clients->links() }}</div>
    </div>
</div>
@endsection