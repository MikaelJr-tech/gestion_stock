@extends('layouts.app')
@section('title', 'Nouveau bon de commande')

@section('content')
<a href="{{ route('appro.commandes.index') }}" class="back-link">← Retour aux bons de commande</a>

<div style="max-width: 960px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer un bon de commande fournisseur</span>
        </div>
        <div class="card-body">
            <form action="{{ route('appro.commandes.store') }}" method="POST">
                @csrf

                <div class="grid-2 mb-16">
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
                        <label class="form-label">Date commande <span class="req">*</span></label>
                        <input type="date" name="date_commande"
                               value="{{ old('date_commande', today()->toDateString()) }}"
                               class="form-input">
                    </div>
                </div>

                <div class="grid-2 mb-16">
                    <div class="form-group">
                        <label class="form-label">Date livraison prévue</label>
                        <input type="date" name="date_livraison_prevue"
                               value="{{ old('date_livraison_prevue') }}" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <input type="text" name="notes" value="{{ old('notes') }}" class="form-input">
                    </div>
                </div>

                <div class="form-section">
                    <span>Produits commandés</span>
                    <button type="button" onclick="ajouterLigne()" class="btn btn-success btn-sm">+ Ajouter ligne</button>
                </div>

                <div class="table-wrap mb-16">
                    <table class="inline-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th style="width:120px;">Quantité</th>
                                <th style="width:150px;">Prix unitaire</th>
                                <th style="width:140px;">Montant</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="lignes">
                            <tr class="ligne-row">
                                <td>
                                    <select name="produits[0][produit_id]" class="form-select" style="font-size:13px;"
                                            onchange="calculerMontant(this)">
                                        <option value="">— Produit —</option>
                                        @foreach($produits as $p)
                                            <option value="{{ $p->id }}">{{ $p->nom }} ({{ $p->unite }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="produits[0][quantite]" min="1" value="1"
                                           class="form-input quantite" oninput="calculerMontant(this)">
                                </td>
                                <td>
                                    <input type="number" name="produits[0][prix_unitaire]" min="0" step="0.01" value="0"
                                           class="form-input prix" oninput="calculerMontant(this)">
                                </td>
                                <td>
                                    <span class="montant fw-600 text-accent">0</span>
                                </td>
                                <td style="text-align:center;">
                                    <button type="button" onclick="supprimerLigne(this)" class="btn btn-danger btn-xs">✕</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right fw-700">TOTAL :</td>
                                <td class="fw-700 text-accent" id="total">0 FCFA</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end;">
                    <a href="{{ route('appro.commandes.index') }}" class="btn btn-secondary">Annuler</a>
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
            <select name="produits[${index}][produit_id]" class="form-select" style="font-size:13px;" onchange="calculerMontant(this)">
                <option value="">— Produit —</option>
                ${produits.map(p => `<option value="${p.id}">${p.nom} (${p.unite})</option>`).join('')}
            </select>
        </td>
        <td><input type="number" name="produits[${index}][quantite]" min="1" value="1" class="form-input quantite" oninput="calculerMontant(this)"></td>
        <td><input type="number" name="produits[${index}][prix_unitaire]" min="0" step="0.01" value="0" class="form-input prix" oninput="calculerMontant(this)"></td>
        <td><span class="montant fw-600 text-accent">0</span></td>
        <td style="text-align:center;"><button type="button" onclick="supprimerLigne(this)" class="btn btn-danger btn-xs">✕</button></td>`;
    tbody.appendChild(tr);
    index++;
    calculerTotal();
}

function supprimerLigne(btn) {
    if (document.querySelectorAll('.ligne-row').length > 1) {
        btn.closest('tr').remove();
        calculerTotal();
    }
}

function calculerMontant(el) {
    const row = el.closest('tr');
    const qte  = parseFloat(row.querySelector('.quantite').value) || 0;
    const prix = parseFloat(row.querySelector('.prix').value) || 0;
    row.querySelector('.montant').textContent = new Intl.NumberFormat('fr-FR').format(qte * prix);
    calculerTotal();
}

function calculerTotal() {
    let total = 0;
    document.querySelectorAll('.ligne-row').forEach(row => {
        const qte  = parseFloat(row.querySelector('.quantite').value) || 0;
        const prix = parseFloat(row.querySelector('.prix').value) || 0;
        total += qte * prix;
    });
    document.getElementById('total').textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
}
</script>
@endsection
