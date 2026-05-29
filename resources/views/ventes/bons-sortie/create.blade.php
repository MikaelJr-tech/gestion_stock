@extends('layouts.app')
@section('title', 'Nouveau bon de sortie')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Créer un bon de sortie</h3>

    <form action="{{ route('ventes.bons-sortie.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Motif <span class="text-red-500">*</span></label>
                <select name="motif" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="périmé">Périmé</option>
                    <option value="non_vendu">Non vendu</option>
                    <option value="casse">Casse</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de sortie <span class="text-red-500">*</span></label>
                <input type="date" name="date_sortie" value="{{ old('date_sortie', today()->toDateString()) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
        </div>

        <div>
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-semibold text-gray-700">Produits</h4>
                <button type="button" onclick="ajouterLigne()"
                        class="bg-green-600 text-white px-3 py-1 rounded text-sm">+ Ajouter ligne</button>
            </div>
            <table class="w-full text-sm border">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-3 py-2 text-left">Produit</th>
                        <th class="px-3 py-2 text-left">Stock actuel</th>
                        <th class="px-3 py-2 text-left">Quantité à sortir</th>
                        <th class="px-3 py-2 text-left">Valeur unitaire</th>
                        <th class="px-3 py-2"></th>
                    </tr>
                </thead>
                <tbody id="lignes">
                    <tr class="ligne-row">
                        <td class="px-3 py-2">
                            <select name="produits[0][produit_id]" class="w-full border rounded px-2 py-1 text-sm" onchange="afficherStock(this)">
                                <option value="">-- Produit --</option>
                                @foreach($produits as $p)
                                    <option value="{{ $p->id }}" data-stock="{{ $p->stock_actuel }}">
                                        {{ $p->nom }} ({{ $p->unite }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-3 py-2 stock-actuel text-orange-600 font-bold">-</td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[0][quantite]" min="1" value="1"
                                   class="w-24 border rounded px-2 py-1 text-sm">
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[0][valeur_unitaire]" min="0" step="0.01" value="0"
                                   class="w-28 border rounded px-2 py-1 text-sm">
                        </td>
                        <td class="px-3 py-2">
                            <button type="button" onclick="supprimerLigne(this)" class="text-red-500">✕</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('ventes.bons-sortie.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>

<script>
let index = 1;
const produits = @json($produits);

function afficherStock(select) {
    const row = select.closest('tr');
    const option = select.options[select.selectedIndex];
    row.querySelector('.stock-actuel').textContent = option.dataset.stock || '-';
}

function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td class="px-3 py-2">
            <select name="produits[${index}][produit_id]" class="w-full border rounded px-2 py-1 text-sm" onchange="afficherStock(this)">
                <option value="">-- Produit --</option>
                ${produits.map(p => `<option value="${p.id}" data-stock="${p.stock_actuel}">${p.nom} (${p.unite})</option>`).join('')}
            </select>
        </td>
        <td class="px-3 py-2 stock-actuel text-orange-600 font-bold">-</td>
        <td class="px-3 py-2"><input type="number" name="produits[${index}][quantite]" min="1" value="1" class="w-24 border rounded px-2 py-1 text-sm"></td>
        <td class="px-3 py-2"><input type="number" name="produits[${index}][valeur_unitaire]" min="0" step="0.01" value="0" class="w-28 border rounded px-2 py-1 text-sm"></td>
        <td class="px-3 py-2"><button type="button" onclick="supprimerLigne(this)" class="text-red-500">✕</button></td>`;
    tbody.appendChild(tr);
    index++;
}

function supprimerLigne(btn) {
    if (document.querySelectorAll('.ligne-row').length > 1) btn.closest('tr').remove();
}
</script>
@endsection
