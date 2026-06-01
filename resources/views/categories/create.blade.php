@extends('layouts.app')
@section('title', 'Nouvelle catégorie')

@section('content')
<a href="{{ route('categories.index') }}" class="back-link">← Retour aux catégories</a>

<div style="max-width: 480px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer une catégorie client</span>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nom <span class="req">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-input" placeholder="Ex: Grossiste, Détaillant...">
                    @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Remise par défaut (%)</label>
                    <input type="number" name="remise_default" value="{{ old('remise_default', 0) }}"
                           step="0.01" min="0" max="100" class="form-input">
                    @error('remise_default')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection