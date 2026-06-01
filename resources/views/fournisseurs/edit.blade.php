@extends('layouts.app')
@section('title', 'Modifier fournisseur')

@section('content')
<a href="{{ route('fournisseurs.index') }}" class="back-link">← Retour aux fournisseurs</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $fournisseur->nom }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('fournisseurs.update', $fournisseur) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nom <span class="req">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom', $fournisseur->nom) }}" class="form-input">
                    @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $fournisseur->telephone) }}" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $fournisseur->email) }}" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse</label>
                    <textarea name="adresse" rows="2" class="form-textarea">{{ old('adresse', $fournisseur->adresse) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">N° Contribuable</label>
                    <input type="text" name="numero_contribuable" value="{{ old('numero_contribuable', $fournisseur->numero_contribuable) }}" class="form-input">
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection