@extends('layouts.app')
@section('title', 'Nouveau bon d\'entrée')

@section('content')
<a href="{{ route('appro.bons-entree.index') }}" class="back-link">← Retour aux bons d'entrée</a>

<div style="max-width: 960px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer un bon d'entrée</span>
        </div>
        <div class="card-body">
            <form action="{{ route('appro.bons-entree.store') }}" method="POST">
                @csrf

                <div class="grid-2 mb-16">
                    <div class="form-group">
                        <label class="form-label">Type <span class="req">*</span></label>
                        <select name="type" class="form-select">
                            <option value="don"        {{ old('type') === 'don'        ? 'selected' : '' }}>Don</option>
                            <option value="retour"     {{ old('type') === 'retour'     ? 'selected' : '' }}>Retour</option>
                            <option value="ajustement" {{ old('type') === 'ajustement' ? 'selected' : '' }}>Ajustement</option>
                            <option value="autre"      {{ old('type') === 'autre'      ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date d'entrée <span class="req">*</span></label>
                        <input type="date" name="date_entree"
                               value="{{ old('date_entree', today()->toDateString()) }}"
                               class="form-input">
                    </div>
                </div>

                <div class="grid-2 mb-16">
                    <div class="form-group">
                        <label class="form-label">Source / Donateur</label>
                        <input type="text" name="source" value="{{ old('source') }}" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <input type="text" name="notes" value="{{ old('notes') }}" class="form-input">
                    </div>
                </div>

                <div class="form-section">
                    <span>Produits</span>
                    <button type="button" onclick="ajouterLigne()" class="btn btn-success btn-sm">+ Ajouter ligne</button>
                </div>

                <div class="table-wrap mb-16">
                    <table class="inline-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th style="width:120px;">Quantité</th>
                                <th style="width:150px;">Valeur unitaire</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="lignes">
                            <tr class="ligne-row">
                                <td>
                                    <select name="produits[0][produit_id]" class="form-select" style="font-size:13px;">
                                        <option value="">— Produit —</option>
                                        @foreach($produits as $p)
                                            <option value="{{ $p->id }}">{{ $p->nom }} ({{ $p->unite }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="produits[0][quantite]" min="1" value="1"
                                           class="form-input">
                                </td>
                                <td>
                                    <input type="number" name="produits[0][valeur_unitaire]" min="0" step="0.01" value="0"
                                           class="form-input">
                                </td>
                                <td style="text-align:center;">
                                    <button type="button" onclick="supprimerLigne(this)" class="btn btn-danger btn-xs">✕</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end;">
                    <a href="{{ route('appro.bons-entree.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let index = 1;
const produits = @json($produits);

function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td>
            <select name="produits[${index}][produit_id]" class="form-select" style="font-size:13px;">
                <option value="">— Produit —</option>
                ${produits.map(p => `<option value="${p.id}">${p.nom} (${p.unite})</option>`).join('')}
            </select>
        </td>
        <td><input type="number" name="produits[${index}][quantite]" min="1" value="1" class="form-input"></td>
        <td><input type="number" name="produits[${index}][valeur_unitaire]" min="0" step="0.01" value="0" class="form-input"></td>
        <td style="text-align:center;"><button type="button" onclick="supprimerLigne(this)" class="btn btn-danger btn-xs">✕</button></td>`;
    tbody.appendChild(tr);
    index++;
}

function supprimerLigne(btn) {
    if (document.querySelectorAll('.ligne-row').length > 1) btn.closest('tr').remove();
}
</script>
@endsection
