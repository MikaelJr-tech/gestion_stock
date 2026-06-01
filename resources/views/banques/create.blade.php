@extends('layouts.app')
@section('title', 'Nouvelle banque')

@section('content')
<a href="{{ route('banques.index') }}" class="back-link">← Retour aux banques</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer une banque</span>
        </div>
        <div class="card-body">
            <form action="{{ route('banques.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nom <span class="req">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-input" placeholder="Ex: BICEC, Afriland...">
                    @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Numéro de compte</label>
                    <input type="text" name="numero_compte" value="{{ old('numero_compte') }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Solde initial <span class="req">*</span></label>
                    <input type="number" name="solde" value="{{ old('solde', 0) }}"
                           step="0.01" class="form-input">
                    @error('solde')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('banques.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection