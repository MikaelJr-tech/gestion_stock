@extends('layouts.app')
@section('title', 'Modifier versement')

@section('content')
<a href="{{ route('versements.index') }}" class="back-link">← Retour aux versements</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier le versement</span>
        </div>
        <div class="card-body">
            <form action="{{ route('versements.update', $versement) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Banque</label>
                    <select name="banque_id" class="form-select">
                        @foreach($banques as $banque)
                            <option value="{{ $banque->id }}" {{ old('banque_id', $versement->banque_id) == $banque->id ? 'selected' : '' }}>
                                {{ $banque->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Montant</label>
                    <input type="number" name="montant" value="{{ old('montant', $versement->montant) }}"
                           step="0.01" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Date de versement</label>
                    <input type="date" name="date_versement"
                           value="{{ old('date_versement', $versement->date_versement->format('Y-m-d')) }}"
                           class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Référence</label>
                    <input type="text" name="reference" value="{{ old('reference', $versement->reference) }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="2" class="form-textarea">{{ old('notes', $versement->notes) }}</textarea>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('versements.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection