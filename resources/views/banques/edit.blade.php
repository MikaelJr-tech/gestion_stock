@extends('layouts.app')
@section('title', 'Modifier banque')

@section('content')
<a href="{{ route('banques.index') }}" class="back-link">← Retour aux banques</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $banque->nom }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('banques.update', $banque) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom', $banque->nom) }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Numéro de compte</label>
                    <input type="text" name="numero_compte" value="{{ old('numero_compte', $banque->numero_compte) }}" class="form-input">
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('banques.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection