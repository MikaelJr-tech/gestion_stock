@extends('layouts.app')
@section('title', 'Modifier bon de sortie')

@section('content')
<a href="{{ route('ventes.bons-sortie.index') }}" class="back-link">← Retour aux bons de sortie</a>

<div style="max-width: 860px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $bonSortie->numero }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('ventes.bons-sortie.update', $bonSortie) }}" method="POST">
                @csrf @method('PUT')

                <div class="grid-2 mb-16">
                    <div class="form-group">
                        <label class="form-label">Motif <span class="req">*</span></label>
                        <select name="motif" class="form-select">
                            <option value="périmé"    {{ old('motif', $bonSortie->motif) === 'périmé'    ? 'selected' : '' }}>Périmé</option>
                            <option value="non_vendu" {{ old('motif', $bonSortie->motif) === 'non_vendu' ? 'selected' : '' }}>Non vendu</option>
                            <option value="casse"     {{ old('motif', $bonSortie->motif) === 'casse'     ? 'selected' : '' }}>Casse</option>
                            <option value="autre"     {{ old('motif', $bonSortie->motif) === 'autre'     ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date de sortie <span class="req">*</span></label>
                        <input type="date" name="date_sortie"
                               value="{{ old('date_sortie', $bonSortie->date_sortie->format('Y-m-d')) }}"
                               class="form-input">
                    </div>
                </div>

                <div class="form-group mb-16">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="2" class="form-textarea">{{ old('notes', $bonSortie->notes) }}</textarea>
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
                                <th>Quantité</th>
                                <th>Valeur unitaire</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="lignes">
                            @foreach($bonSortie->lignes as $i => $ligne)
                            <tr class="ligne-row">
                                <td>
                                    <select name="produits[{{ $i }}][produit_id]" class="form-select" style="font-size:13px;">
                                        @foreach($produits as $p)
                                            <option value="{{ $p->id }}" {{ $ligne->produit_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->nom }} ({{ $p->unite }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width:110px;">
                                    <input type="number" name="produits[{{ $i }}][quantite]"
                                           value="{{ $ligne->quantite }}" min="1" class="form-input">
                                </td>
                                <td style="width:140px;">
                                    <input type="number" name="produits[{{ $i }}][valeur_unitaire]"
                                           value="{{ $ligne->valeur_unitaire }}" step="0.01" class="form-input">
                                </td>
                                <td style="width:40px; text-align:center;">
                                    <button type="button" onclick="supprimerLigne(this)"
                                            class="btn btn-danger btn-xs">✕</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end;">
                    <a href="{{ route('ventes.bons-sortie.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let index = {{ $bonSortie->lignes->count() }};
const produits = @json($produits);

function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td>
            <select name="produits[${index}][produit_id]" class="form-select" style="font-size:13px;">
                ${produits.map(p => `<option value="${p.id}">${p.nom} (${p.unite})</option>`).join('')}
            </select>
        </td>
        <td style="width:110px;">
            <input type="number" name="produits[${index}][quantite]" min="1" value="1" class="form-input">
        </td>
        <td style="width:140px;">
            <input type="number" name="produits[${index}][valeur_unitaire]" step="0.01" value="0" class="form-input">
        </td>
        <td style="width:40px; text-align:center;">
            <button type="button" onclick="supprimerLigne(this)" class="btn btn-danger btn-xs">✕</button>
        </td>`;
    tbody.appendChild(tr);
    index++;
}

function supprimerLigne(btn) {
    if (document.querySelectorAll('.ligne-row').length > 1) {
        btn.closest('tr').remove();
    }
}
</script>
@endsection
