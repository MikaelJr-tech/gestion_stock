@extends('layouts.app')
@section('title', 'Nouvelle commande client')

@section('content')
<a href="{{ route('ventes.commandes.index') }}" class="back-link">← Retour aux commandes</a>

<div style="max-width: 1000px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer une commande client</span>
        </div>
        <div class="card-body">
            <form action="{{ route('ventes.commandes.store') }}" method="POST">
                @csrf

                <div class="grid-2 mb-16">
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
                        <label class="form-label">Date commande <span class="req">*</span></label>
                        <input type="date" name="date_commande"
                               value="{{ old('date_commande', today()->toDateString()) }}"
                               class="form-input">
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
                                <th style="width:90px;">Stock dispo</th>
                                <th style="width:110px;">Quantité</th>
                                <th style="width:140px;">Prix unitaire</th>
                                <th style="width:90px;">Remise %</th>
                                <th style="width:130px;">Montant</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="lignes">
                            <tr class="ligne-row">
                                <td>
                                    <select name="produits[0][produit_id]" class="form-select" style="font-size:13px;"
                                            onchange="remplirPrix(this)">
                                        <option value="">— Produit —</option>
                                        @foreach($produits as $p)
                                            <option value="{{ $p->id }}"
                                                    data-prix="{{ $p->prix_vente }}"
                                                    data-stock="{{ $p->stock_actuel }}">
                                                {{ $p->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="stock-dispo fw-600 text-success text-center">—</td>
                                <td>
                                    <input type="number" name="produits[0][quantite]" min="1" value="1"
                                           class="form-input quantite" oninput="calculerMontant(this)">
                                </td>
                                <td>
                                    <input type="number" name="produits[0][prix_unitaire]" step="0.01" value="0"
                                           class="form-input prix" oninput="calculerMontant(this)">
                                </td>
                                <td>
                                    <input type="number" name="produits[0][remise]" min="0" max="100" value="0"
                                           class="form-input remise" oninput="calculerMontant(this)">
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
                                <td colspan="5" class="text-right fw-700">TOTAL :</td>
                                <td class="fw-700 text-accent" id="total">0 FCFA</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end;">
                    <a href="{{ route('ventes.commandes.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let index = 1;
const produits = @json($produits);

function remplirPrix(select) {
    const row    = select.closest('tr');
    const option = select.options[select.selectedIndex];
    row.querySelector('.prix').value = option.dataset.prix || 0;
    row.querySelector('.stock-dispo').textContent = option.dataset.stock || '—';
    calculerMontant(select);
}

function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td>
            <select name="produits[${index}][produit_id]" class="form-select" style="font-size:13px;" onchange="remplirPrix(this)">
                <option value="">— Produit —</option>
                ${produits.map(p => `<option value="${p.id}" data-prix="${p.prix_vente}" data-stock="${p.stock_actuel}">${p.nom}</option>`).join('')}
            </select>
        </td>
        <td class="stock-dispo fw-600 text-success text-center">—</td>
        <td><input type="number" name="produits[${index}][quantite]" min="1" value="1" class="form-input quantite" oninput="calculerMontant(this)"></td>
        <td><input type="number" name="produits[${index}][prix_unitaire]" step="0.01" value="0" class="form-input prix" oninput="calculerMontant(this)"></td>
        <td><input type="number" name="produits[${index}][remise]" min="0" max="100" value="0" class="form-input remise" oninput="calculerMontant(this)"></td>
        <td><span class="montant fw-600 text-accent">0</span></td>
        <td style="text-align:center;"><button type="button" onclick="supprimerLigne(this)" class="btn btn-danger btn-xs">✕</button></td>`;
    tbody.appendChild(tr);
    index++;
}

function supprimerLigne(btn) {
    if (document.querySelectorAll('.ligne-row').length > 1) {
        btn.closest('tr').remove();
        calculerTotal();
    }
}

function calculerMontant(el) {
    const row    = el.closest('tr');
    const qte    = parseFloat(row.querySelector('.quantite').value) || 0;
    const prix   = parseFloat(row.querySelector('.prix').value) || 0;
    const remise = parseFloat(row.querySelector('.remise').value) || 0;
    row.querySelector('.montant').textContent =
        new Intl.NumberFormat('fr-FR').format(qte * prix * (1 - remise / 100));
    calculerTotal();
}

function calculerTotal() {
    let total = 0;
    document.querySelectorAll('.ligne-row').forEach(row => {
        const qte    = parseFloat(row.querySelector('.quantite').value) || 0;
        const prix   = parseFloat(row.querySelector('.prix').value) || 0;
        const remise = parseFloat(row.querySelector('.remise').value) || 0;
        total += qte * prix * (1 - remise / 100);
    });
    document.getElementById('total').textContent =
        new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
}
</script>
@endsection
