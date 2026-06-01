@extends('layouts.app')
@section('title', 'Modifier catégorie')

@section('content')
<a href="{{ route('categories.index') }}" class="back-link">← Retour aux catégories</a>

<div style="max-width: 480px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $category->nom }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom', $category->nom) }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Remise par défaut (%)</label>
                    <input type="number" name="remise_default"
                           value="{{ old('remise_default', $category->remise_default) }}"
                           step="0.01" min="0" max="100" class="form-input">
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection