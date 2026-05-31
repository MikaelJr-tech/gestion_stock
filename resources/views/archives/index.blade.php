@extends('layouts.app')
@section('title', 'Archives XML')

@section('content')

<div class="page-header mb-20">
    <h1 class="page-title">🗄 Archives XML</h1>
</div>

{{-- Restaurer depuis un fichier --}}
<div class="card mb-20">
    <div class="card-header">
        <span class="card-title">📤 Restaurer depuis un fichier XML</span>
    </div>
    <div class="card-body">
        <form action="{{ route('archives.restaurer') }}" method="POST" enctype="multipart/form-data"
              class="flex gap-12" style="align-items: flex-end;">
            @csrf
            <div class="form-group mb-0" style="flex:1;">
                <label class="form-label">Sélectionner un fichier XML</label>
                <input type="file" name="fichier" accept=".xml" class="form-input">
            </div>
            <button type="submit" class="btn btn-primary">
                ♻ Restaurer
            </button>
        </form>
        <p class="text-400 mt-8" style="font-size:12px;">
            ⚠ La restauration recrée les enregistrements supprimés avec un nouvel ID.
        </p>
    </div>
</div>

{{-- Liste des archives --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">📁 Fichiers archivés ({{ $fichiers->count() }})</span>
    </div>
    @if($fichiers->isEmpty())
    <div class="empty-state">
        <div class="empty-state-icon">🗄</div>
        <div class="empty-state-text">Aucune archive disponible.</div>
    </div>
    @else
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Fichier</th>
                    <th>Date</th>
                    <th>Taille</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fichiers as $fichier)
                <tr>
                    <td class="font-mono fw-500 text-900">{{ $fichier['nom'] }}</td>
                    <td class="text-500">{{ $fichier['date'] }}</td>
                    <td class="text-400">{{ round($fichier['taille'] / 1024, 2) }} Ko</td>
                    <td class="actions-cell">
                        <a href="{{ route('archives.telecharger', $fichier['nom']) }}"
                           class="btn btn-info btn-sm">⬇ Télécharger</a>
                        <form action="{{ route('archives.supprimer', $fichier['nom']) }}"
                              method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer cette archive ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
