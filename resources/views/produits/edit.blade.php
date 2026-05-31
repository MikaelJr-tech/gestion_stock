@extends('layouts.app')
@section('title', 'Modifier produit')

@section('content')
<a href="{{ route('produits.index') }}" class="back-link">← Retour aux produits</a>

<div style="max-width: 720px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $produit->nom }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('produits.update', $produit) }}" method="POST">
                @csrf @method('PUT')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" value="{{ old('code', $produit->code) }}" class="form-input">
                        @error('code')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom', $produit->nom) }}" class="form-input">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Famille</label>
                        <select name="famille_id" class="form-select">
                            @foreach($familles as $f)
                                <option value="{{ $f->id }}" {{ old('famille_id', $produit->famille_id) == $f->id ? 'selected' : '' }}>
                                    {{ $f->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unité</label>
                        <input type="text" name="unite" value="{{ old('unite', $produit->unite) }}" class="form-input">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Prix achat</label>
                        <input type="number" name="prix_achat" value="{{ old('prix_achat', $produit->prix_achat) }}"
                               step="0.01" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prix vente</label>
                        <input type="number" name="prix_vente" value="{{ old('prix_vente', $produit->prix_vente) }}"
                               step="0.01" class="form-input">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Stock minimum</label>
                        <input type="number" name="stock_minimum" value="{{ old('stock_minimum', $produit->stock_minimum) }}"
                               class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select">
                            <option value="simple" {{ old('type', $produit->type) == 'simple' ? 'selected' : '' }}>Simple</option>
                            <option value="père"   {{ old('type', $produit->type) == 'père'   ? 'selected' : '' }}>Père</option>
                            <option value="fils"   {{ old('type', $produit->type) == 'fils'   ? 'selected' : '' }}>Fils</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Date d'expiration</label>
                    <input type="date" name="date_expiration"
                           value="{{ old('date_expiration', $produit->date_expiration?->format('Y-m-d')) }}"
                           class="form-input">
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
