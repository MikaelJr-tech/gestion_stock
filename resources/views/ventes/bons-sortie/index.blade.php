@extends('layouts.app')
@section('title', 'Bons de sortie')

@section('content')
<div class="page-header">
    <h1 class="page-title">Bons de sortie</h1>
    @can('ventes.bons-sortie.creer')
    <a href="{{ route('ventes.bons-sortie.create') }}" class="btn btn-primary">+ Nouveau bon de sortie</a>
    @endcan
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Motif</th>
                    <th>Date</th>
                    <th>Créé par</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bons as $bon)
                <tr>
                    <td class="font-mono fw-600 text-900">{{ $bon->numero }}</td>
                    <td>
                        @if($bon->motif === 'périmé')
                            <span class="badge badge-danger">{{ $bon->motif }}</span>
                        @elseif($bon->motif === 'casse')
                            <span class="badge badge-warning">{{ $bon->motif }}</span>
                        @else
                            <span class="badge badge-neutral">{{ $bon->motif }}</span>
                        @endif
                    </td>
                    <td class="text-500">{{ $bon->date_sortie->format('d/m/Y') }}</td>
                    <td class="text-500">{{ $bon->user->name }}</td>
                    <td class="actions-cell">
                        @can('ventes.bons-sortie.voir')
                        <a href="{{ route('ventes.bons-sortie.show', $bon) }}" class="btn btn-secondary btn-sm">Voir</a>
                        @endcan
                        @can('ventes.bons-sortie.imprimer')
                        <a href="{{ route('ventes.bons-sortie.imprimer', $bon) }}" target="_blank" class="btn btn-success btn-sm">PDF</a>
                        @endcan
                        @can('ventes.bons-sortie.supprimer')
                        <form action="{{ route('ventes.bons-sortie.destroy', $bon) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer ? Le stock sera restauré.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon">📤</div>
                            <div class="empty-state-text">Aucun bon de sortie.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $bons->links() }}</div>
</div>
@endsection
