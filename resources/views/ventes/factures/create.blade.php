@extends('layouts.app')
@section('title', 'Nouvelle facture client')

@section('content')
<a href="{{ route('ventes.factures.index') }}" class="back-link">← Retour aux factures</a>

<div style="max-width: 640px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer une facture client</span>
        </div>
        <div class="card-body">
            <form action="{{ route('ventes.factures.store') }}" method="POST">
                @csrf

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Client <span class="req">*</span></label>
                        <select name="client_id" class="form-select">
                            <option value="">— Choisir —</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}" {{ old('client_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Commande liée</label>
                        <select name="commande_id" class="form-select">
                            <option value="">— Aucune (vente comptant) —</option>
                            @foreach($commandes as $cc)
                                <option value="{{ $cc->id }}" {{ old('commande_id') == $cc->id ? 'selected' : '' }}>
                                    {{ $cc->numero }} — {{ $cc->client->nom }}
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
                        @error('date_facture')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type de vente <span class="req">*</span></label>
                        <select name="type_vente" class="form-select">
                            <option value="crédit"   {{ old('type_vente') === 'crédit'   ? 'selected' : '' }}>Crédit</option>
                            <option value="comptant" {{ old('type_vente') === 'comptant' ? 'selected' : '' }}>Comptant</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Montant HT <span class="req">*</span></label>
                        <input type="number" name="montant_ht" value="{{ old('montant_ht', 0) }}"
                               step="0.01" id="montant_ht" oninput="calculerTTC()" class="form-input">
                        @error('montant_ht')<div class="form-error">{{ $message }}</div>@enderror
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
                    <a href="{{ route('ventes.factures.index') }}" class="btn btn-secondary">Annuler</a>
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
