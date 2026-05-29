@extends('layouts.app')
@section('title', 'Nouveau bon d\'entrée')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Créer un bon d'entrée</h3>

    <form action="{{ route('appro.bons-entree.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="don" {{ old('type') === 'don' ? 'selected' : '' }}>Don</option>
                    <option value="retour" {{ old('type') === 'retour' ? 'selected' : '' }}>Retour</option>
                    <option value="ajustement" {{ old('type') === 'ajustement' ? 'selected' : '' }}>Ajustement</option>
                    <option value="autre" {{ old('type') === 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date d'entrée <span class="text-red-500">*</span></label>
                <input type="date" name="date_entree" value="{{ old('date_entree', today()->toDateString()) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Source / Donateur</label>
                <input type="text" name="source" value="{{ old('source') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <input type="text" name="notes" value="{{ old('notes') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
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
                        <th class="px-3 py-2 text-left">Quantité</th>
                        <th class="px-3 py-2 text-left">Valeur unitaire</th>
                        <th class="px-3 py-2"></th>
                    </tr>
                </thead>
                <tbody id="lignes">
                    <tr class="ligne-row">
                        <td class="px-3 py-2">
                            <select name="produits[0][produit_id]" class="w-full border rounded px-2 py-1 text-sm">
                                <option value="">-- Produit --</option>
                                @foreach($produits as $p)
                                    <option value="{{ $p->id }}">{{ $p->nom }} ({{ $p->unite }})</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[0][quantite]" min="1" value="1"
                                   class="w-24 border rounded px-2 py-1 text-sm">
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[0][valeur_unitaire]" min="0" step="0.01" value="0"
                                   class="w-32 border rounded px-2 py-1 text-sm">
                        </td>
                        <td class="px-3 py-2">
                            <button type="button" onclick="supprimerLigne(this)" class="text-red-500">✕</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('appro.bons-entree.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>

<script>
let index = 1;
const produits = @json($produits);
function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td class="px-3 py-2">
            <select name="produits[${index}][produit_id]" class="w-full border rounded px-2 py-1 text-sm">
                <option value="">-- Produit --</option>
                ${produits.map(p => `<option value="${p.id}">${p.nom} (${p.unite})</option>`).join('')}
            </select>
        </td>
        <td class="px-3 py-2">
            <input type="number" name="produits[${index}][quantite]" min="1" value="1" class="w-24 border rounded px-2 py-1 text-sm">
        </td>
        <td class="px-3 py-2">
            <input type="number" name="produits[${index}][valeur_unitaire]" min="0" step="0.01" value="0" class="w-32 border rounded px-2 py-1 text-sm">
        </td>
        <td class="px-3 py-2">
            <button type="button" onclick="supprimerLigne(this)" class="text-red-500">✕</button>
        </td>`;
    tbody.appendChild(tr);
    index++;
}
function supprimerLigne(btn) {
    if (document.querySelectorAll('.ligne-row').length > 1) btn.closest('tr').remove();
}
</script>
@endsection
