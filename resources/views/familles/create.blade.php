@extends('layouts.app')
@section('title', 'Nouvelle famille')

@section('content')
<a href="{{ route('familles.index') }}" class="back-link">← Retour aux familles</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer une famille de produits</span>
        </div>
        <div class="card-body">
            <form action="{{ route('familles.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nom <span class="req">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-input" placeholder="Ex: Boissons, Alimentaire...">
                    @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-textarea"
                              placeholder="Description optionnelle...">{{ old('description') }}</textarea>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('familles.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
