@extends('layouts.app')
@section('title', 'Modifier famille')

@section('content')
<a href="{{ route('familles.index') }}" class="back-link">← Retour aux familles</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $famille->nom }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('familles.update', $famille) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nom <span class="req">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom', $famille->nom) }}" class="form-input">
                    @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-textarea">{{ old('description', $famille->description) }}</textarea>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('familles.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
