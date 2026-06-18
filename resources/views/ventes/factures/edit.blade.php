@extends('layouts.app')
@section('title', 'Modifier facture client')

@section('content')
<a href="{{ route('ventes.factures.index') }}" class="back-link">← Retour aux factures</a>

<div style="max-width: 640px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $facture->numero }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('ventes.factures.update', $facture) }}" method="POST">
                @csrf @method('PUT')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Client</label>
                        <select name="client_id" class="form-select">
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}"
                                    {{ old('client_id', $facture->client_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Commande liée</label>
                        <select name="commande_id" class="form-select">
                            <option value="">— Aucune —</option>
                            @foreach($commandes as $cc)
                                <option value="{{ $cc->id }}"
                                    {{ old('commande_id', $facture->commande_id) == $cc->id ? 'selected' : '' }}>
                                    {{ $cc->numero }} — {{ $cc->client->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Date facture</label>
                        <input type="date" name="date_facture"
                               value="{{ old('date_facture', $facture->date_facture->format('Y-m-d')) }}"
                               class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type de vente</label>
                        <select name="type_vente" class="form-select">
                            <option value="crédit"   {{ old('type_vente', $facture->type_vente) === 'crédit'   ? 'selected' : '' }}>Crédit</option>
                            <option value="comptant" {{ old('type_vente', $facture->type_vente) === 'comptant' ? 'selected' : '' }}>Comptant</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Montant HT</label>
                        <input type="number" name="montant_ht"
                               value="{{ old('montant_ht', $facture->montant_ht) }}"
                               step="0.01" id="montant_ht" oninput="calculerTTC()" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">TVA (%)</label>
                        <input type="number" name="tva"
                               value="{{ old('tva', $facture->tva) }}"
                               step="0.01" min="0" max="100" id="tva" oninput="calculerTTC()"
                               class="form-input">
                    </div>
                </div>

                <div class="ttc-box mb-16">
                    Montant TTC :
                    <span id="montant_ttc" class="fw-700">
                        {{ number_format($facture->montant_ttc, 0, ',', ' ') }}
                    </span> FCFA
                </div>

                <div class="flex gap-8" style="justify-content: flex-end;">
                    <a href="{{ route('ventes.factures.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
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
