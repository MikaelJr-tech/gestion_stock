@extends('layouts.app')
@section('title', 'Nouveau client')

@section('content')
<a href="{{ route('clients.index') }}" class="back-link">← Retour aux clients</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer un client</span>
        </div>
        <div class="card-body">
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nom <span class="req">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}" class="form-input">
                    @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Catégorie <span class="req">*</span></label>
                    <select name="categorie_id" class="form-select">
                        <option value="">— Choisir —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse</label>
                    <textarea name="adresse" rows="2" class="form-textarea">{{ old('adresse') }}</textarea>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection