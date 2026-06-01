@extends('layouts.app')
@section('title', 'Modifier client')

@section('content')
<a href="{{ route('clients.index') }}" class="back-link">← Retour aux clients</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $client->nom }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('clients.update', $client) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom', $client->nom) }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('categorie_id', $client->categorie_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $client->telephone) }}" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $client->email) }}" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse</label>
                    <textarea name="adresse" rows="2" class="form-textarea">{{ old('adresse', $client->adresse) }}</textarea>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection