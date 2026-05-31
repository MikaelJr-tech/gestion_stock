@extends('layouts.app')
@section('title', 'Nouveau produit')

@section('content')
<a href="{{ route('produits.index') }}" class="back-link">← Retour aux produits</a>

<div style="max-width: 720px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer un produit</span>
        </div>
        <div class="card-body">
            <form action="{{ route('produits.store') }}" method="POST">
                @csrf

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Code <span class="req">*</span></label>
                        <input type="text" name="code" value="{{ old('code') }}" class="form-input" placeholder="Ex: BOI-001">
                        @error('code')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom <span class="req">*</span></label>
                        <input type="text" name="nom" value="{{ old('nom') }}" class="form-input">
                        @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Famille <span class="req">*</span></label>
                        <select name="famille_id" class="form-select">
                            <option value="">— Choisir —</option>
                            @foreach($familles as $f)
                                <option value="{{ $f->id }}" {{ old('famille_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('famille_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unité <span class="req">*</span></label>
                        <input type="text" name="unite" value="{{ old('unite') }}"
                               class="form-input" placeholder="kg, litre, pièce...">
                        @error('unite')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Prix achat <span class="req">*</span></label>
                        <input type="number" name="prix_achat" value="{{ old('prix_achat', 0) }}"
                               step="0.01" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prix vente <span class="req">*</span></label>
                        <input type="number" name="prix_vente" value="{{ old('prix_vente', 0) }}"
                               step="0.01" class="form-input">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Stock minimum <span class="req">*</span></label>
                        <input type="number" name="stock_minimum" value="{{ old('stock_minimum', 0) }}"
                               class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type <span class="req">*</span></label>
                        <select name="type" class="form-select">
                            <option value="simple" {{ old('type') == 'simple' ? 'selected' : '' }}>Simple</option>
                            <option value="père"   {{ old('type') == 'père'   ? 'selected' : '' }}>Père (parent)</option>
                            <option value="fils"   {{ old('type') == 'fils'   ? 'selected' : '' }}>Fils (enfant)</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Produit parent (si fils)</label>
                        <select name="produit_parent_id" class="form-select">
                            <option value="">— Aucun —</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}" {{ old('produit_parent_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Facteur de fraction</label>
                        <input type="number" name="facteur_fraction" value="{{ old('facteur_fraction', 1) }}"
                               step="0.0001" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Date d'expiration</label>
                    <input type="date" name="date_expiration" value="{{ old('date_expiration') }}"
                           class="form-input">
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
