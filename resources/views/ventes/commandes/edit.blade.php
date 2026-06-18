@extends('layouts.app')
@section('title', 'Modifier commande client')

@section('content')
<a href="{{ route('ventes.commandes.index') }}" class="back-link">← Retour aux commandes</a>

<div style="max-width: 1000px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $commande->numero }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('ventes.commandes.update', $commande) }}" method="POST">
                @csrf @method('PUT')

                <div class="grid-2 mb-16">
                    <div class="form-group">
                        <label class="form-label">Client</label>
                        <select name="client_id" class="form-select">
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}"
                                    {{ old('client_id', $commande->client_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date commande</label>
                        <input type="date" name="date_commande"
                               value="{{ old('date_commande', $commande->date_commande->format('Y-m-d')) }}"
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
                                <th style="width:110px;">Quantité</th>
                                <th style="width:140px;">Prix unitaire</th>
                                <th style="width:90px;">Remise %</th>
                                <th style="width:130px;">Montant</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="lignes">
                            @foreach($commande->lignes as $i => $ligne)
                            <tr class="ligne-row">
                                <td>
                                    <select name="produits[{{ $i }}][produit_id]" class="form-select" style="font-size:13px;">
                                        @foreach($produits as $p)
                                            <option value="{{ $p->id }}" {{ $ligne->produit_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="produits[{{ $i }}][quantite]"
                                           value="{{ $ligne->quantite }}" min="1"
                                           class="form-input quantite" oninput="calculerMontant(this)">
                                </td>
                                <td>
                                    <input type="number" name="produits[{{ $i }}][prix_unitaire]"
                                           value="{{ $ligne->prix_unitaire }}" step="0.01"
                                           class="form-input prix" oninput="calculerMontant(this)">
                                </td>
                                <td>
                                    <input type="number" name="produits[{{ $i }}][remise]"
                                           value="{{ $ligne->remise }}" min="0" max="100"
                                           class="form-input remise" oninput="calculerMontant(this)">
                                </td>
                                <td>
                                    <span class="montant fw-600 text-accent">
                                        {{ number_format($ligne->montant, 0, ',', ' ') }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <button type="button" onclick="supprimerLigne(this)" class="btn btn-danger btn-xs">✕</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right fw-700">TOTAL :</td>
                                <td class="fw-700 text-accent" id="total">
                                    {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end;">
                    <a href="{{ route('ventes.commandes.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let index = {{ $commande->lignes->count() }};
const produits = @json($produits);

function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td>
            <select name="produits[${index}][produit_id]" class="form-select" style="font-size:13px;">
                <option value="">— Produit —</option>
                ${produits.map(p => `<option value="${p.id}">${p.nom}</option>`).join('')}
            </select>
        </td>
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