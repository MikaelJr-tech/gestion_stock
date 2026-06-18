@extends('layouts.app')
@section('title', 'Nouveau bon de sortie')

@section('content')
<a href="{{ route('ventes.bons-sortie.index') }}" class="back-link">← Retour aux bons de sortie</a>

<div style="max-width: 960px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer un bon de sortie</span>
        </div>
        <div class="card-body">
            <form action="{{ route('ventes.bons-sortie.store') }}" method="POST">
                @csrf

                <div class="grid-2 mb-16">
                    <div class="form-group">
                        <label class="form-label">Motif <span class="req">*</span></label>
                        <select name="motif" class="form-select">
                            <option value="périmé">Périmé</option>
                            <option value="non_vendu">Non vendu</option>
                            <option value="casse">Casse</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date de sortie <span class="req">*</span></label>
                        <input type="date" name="date_sortie"
                               value="{{ old('date_sortie', today()->toDateString()) }}"
                               class="form-input">
                    </div>
                </div>

                <div class="form-group mb-16">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="2" class="form-textarea">{{ old('notes') }}</textarea>
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
                                <th style="width:100px;">Stock actuel</th>
                                <th style="width:120px;">Quantité à sortir</th>
                                <th style="width:150px;">Valeur unitaire</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="lignes">
                            <tr class="ligne-row">
                                <td>
                                    <select name="produits[0][produit_id]" class="form-select" style="font-size:13px;"
                                            onchange="afficherStock(this)">
                                        <option value="">— Produit —</option>
                                        @foreach($produits as $p)
                                            <option value="{{ $p->id }}" data-stock="{{ $p->stock_actuel }}">
                                                {{ $p->nom }} ({{ $p->unite }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="stock-actuel fw-600 text-warning text-center">—</td>
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
                    <a href="{{ route('ventes.bons-sortie.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let index = 1;
const produits = @json($produits);

function afficherStock(select) {
    const row    = select.closest('tr');
    const option = select.options[select.selectedIndex];
    row.querySelector('.stock-actuel').textContent = option.dataset.stock || '—';
}

function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td>
            <select name="produits[${index}][produit_id]" class="form-select" style="font-size:13px;" onchange="afficherStock(this)">
                <option value="">— Produit —</option>
                ${produits.map(p => `<option value="${p.id}" data-stock="${p.stock_actuel}">${p.nom} (${p.unite})</option>`).join('')}
            </select>
        </td>
        <td class="stock-actuel fw-600 text-warning text-center">—</td>
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