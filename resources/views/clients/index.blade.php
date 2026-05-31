@extends('layouts.app')
@section('title', 'Clients')

@section('content')
<div class="page-header">
    <h1 class="page-title">Clients</h1>
    @can('clients.creer')
    <a href="{{ route('clients.create') }}" class="btn btn-primary">+ Nouveau client</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Solde</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td class="fw-600 text-900">{{ $client->nom }}</td>
                    <td>
                        <span class="badge badge-neutral">{{ $client->categorie->nom ?? '—' }}</span>
                    </td>
                    <td class="text-500">{{ $client->telephone ?? '—' }}</td>
                    <td class="text-500">{{ $client->email ?? '—' }}</td>
                    <td>
                        @if($client->solde < 0)
                            <span class="badge badge-danger">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</span>
                        @elseif($client->solde > 0)
                            <span class="badge badge-success">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</span>
                        @else
                            <span class="badge badge-neutral">0 FCFA</span>
                        @endif
                    </td>
                    <td class="actions-cell">
                        @can('clients.voir')
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('clients.modifier')
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @endcan
                        @can('clients.supprimer')
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ce client ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">👥</div>
                            <div class="empty-state-text">Aucun client enregistré.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $clients->links() }}</div>
</div>
@endsection
