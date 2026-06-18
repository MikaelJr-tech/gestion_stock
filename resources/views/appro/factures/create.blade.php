@extends('layouts.app')
@section('title', 'Nouvelle facture fournisseur')

@section('content')
<a href="{{ route('appro.factures.index') }}" class="back-link">← Retour aux factures</a>

<div style="max-width: 640px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer une facture fournisseur</span>
        </div>
        <div class="card-body">
            <form action="{{ route('appro.factures.store') }}" method="POST">
                @csrf

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Fournisseur <span class="req">*</span></label>
                        <select name="fournisseur_id" class="form-select">
                            <option value="">— Choisir —</option>
                            @foreach($fournisseurs as $f)
                                <option value="{{ $f->id }}" {{ old('fournisseur_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('fournisseur_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bon de commande lié</label>
                        <select name="bon_commande_id" class="form-select">
                            <option value="">— Aucun —</option>
                            @foreach($commandes as $bc)
                                <option value="{{ $bc->id }}" {{ old('bon_commande_id') == $bc->id ? 'selected' : '' }}>
                                    {{ $bc->numero }} — {{ $bc->fournisseur->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Date facture <span class="req">*</span></label>
                        <input type="date" name="date_facture"
                               value="{{ old('date_facture', today()->toDateString()) }}"
                               class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date échéance</label>
                        <input type="date" name="date_echeance"
                               value="{{ old('date_echeance') }}" class="form-input">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Montant HT <span class="req">*</span></label>
                        <input type="number" name="montant_ht" value="{{ old('montant_ht', 0) }}"
                               step="0.01" id="montant_ht" oninput="calculerTTC()" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">TVA (%) <span class="req">*</span></label>
                        <input type="number" name="tva" value="{{ old('tva', 0) }}"
                               step="0.01" min="0" max="100" id="tva" oninput="calculerTTC()"
                               class="form-input">
                    </div>
                </div>

                <div class="ttc-box mb-16">
                    Montant TTC :
                    <span id="montant_ttc" class="fw-700">0</span> FCFA
                </div>

                <div class="flex gap-8" style="justify-content: flex-end;">
                    <a href="{{ route('appro.factures.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calculerTTC() {
    const ht  = parseFloat(document.getElementById('montant_ht').value) || 0;
    const tva = parseFloat(document.getElementById('tva').value) || 0;
    document.getElementById('montant_ttc').textContent =
        new Intl.NumberFormat('fr-FR').format(ht * (1 + tva / 100));
}
</script>
@endsection
