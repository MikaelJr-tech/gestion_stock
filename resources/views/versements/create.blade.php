@extends('layouts.app')
@section('title', 'Nouveau versement')

@section('content')
<a href="{{ route('versements.index') }}" class="back-link">← Retour aux versements</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Enregistrer un versement</span>
        </div>
        <div class="card-body">
            <form action="{{ route('versements.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Banque <span class="req">*</span></label>
                    <select name="banque_id" class="form-select">
                        <option value="">— Choisir —</option>
                        @foreach($banques as $banque)
                            <option value="{{ $banque->id }}" {{ old('banque_id') == $banque->id ? 'selected' : '' }}>
                                {{ $banque->nom }} — {{ number_format($banque->solde, 0, ',', ' ') }} FCFA
                            </option>
                        @endforeach
                    </select>
                    @error('banque_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Montant <span class="req">*</span></label>
                    <input type="number" name="montant" value="{{ old('montant') }}"
                           step="0.01" min="0" class="form-input">
                    @error('montant')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Date de versement <span class="req">*</span></label>
                    <input type="date" name="date_versement"
                           value="{{ old('date_versement', today()->toDateString()) }}" class="form-input">
                    @error('date_versement')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Référence</label>
                    <input type="text" name="reference" value="{{ old('reference') }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="2" class="form-textarea">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('versements.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection