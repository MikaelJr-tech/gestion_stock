@extends('layouts.app')
@section('title', 'Nouvelle commande client')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Créer une commande client</h3>

    <form action="{{ route('ventes.commandes.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Client <span class="text-red-500">*</span></label>
                <select name="client_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Choisir --</option>
                    @foreach($clients as $c)
                        <option value="{{ $c->id }}" {{ old('client_id') == $c->id ? 'selected' : '' }}>{{ $c->nom }}</option>
                    @endforeach
                </select>
                @error('client_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date commande <span class="text-red-500">*</span></label>
                <input type="date" name="date_commande" value="{{ old('date_commande', today()->toDateString()) }}"
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
                        <th class="px-3 py-2 text-left">Qté disponible</th>
                        <th class="px-3 py-2 text-left">Quantité</th>
                        <th class="px-3 py-2 text-left">Prix unitaire</th>
                        <th class="px-3 py-2 text-left">Remise %</th>
                        <th class="px-3 py-2 text-left">Montant</th>
                        <th class="px-3 py-2"></th>
                    </tr>
                </thead>
                <tbody id="lignes">
                    <tr class="ligne-row">
                        <td class="px-3 py-2">
                            <select name="produits[0][produit_id]" class="w-full border rounded px-2 py-1 text-sm produit-select" onchange="remplirPrix(this)">
                                <option value="">-- Produit --</option>
                                @foreach($produits as $p)
                                    <option value="{{ $p->id }}" data-prix="{{ $p->prix_vente }}" data-stock="{{ $p->stock_actuel }}">
                                        {{ $p->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-3 py-2 stock-dispo text-green-600 font-bold">-</td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[0][quantite]" min="1" value="1"
                                   class="w-20 border rounded px-2 py-1 text-sm quantite" oninput="calculerMontant(this)">
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[0][prix_unitaire]" step="0.01" value="0"
                                   class="w-28 border rounded px-2 py-1 text-sm prix" oninput="calculerMontant(this)">
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[0][remise]" min="0" max="100" value="0"
                                   class="w-16 border rounded px-2 py-1 text-sm remise" oninput="calculerMontant(this)">
                        </td>
                        <td class="px-3 py-2"><span class="montant font-bold">0</span></td>
                        <td class="px-3 py-2">
                            <button type="button" onclick="supprimerLigne(this)" class="text-red-500">✕</button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50">
                        <td colspan="5" class="px-3 py-2 text-right font-semibold">TOTAL :</td>
                        <td class="px-3 py-2 font-bold text-blue-600" id="total">0 FCFA</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('ventes.commandes.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>

<script>
let index = 1;
const produits = @json($produits);

function remplirPrix(select) {
    const row = select.closest('tr');
    const option = select.options[select.selectedIndex];
    row.querySelector('.prix').value = option.dataset.prix || 0;
    row.querySelector('.stock-dispo').textContent = option.dataset.stock || '-';
    calculerMontant(select);
}

function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td class="px-3 py-2">
            <select name="produits[${index}][produit_id]" class="w-full border rounded px-2 py-1 text-sm produit-select" onchange="remplirPrix(this)">
                <option value="">-- Produit --</option>
                ${produits.map(p => `<option value="${p.id}" data-prix="${p.prix_vente}" data-stock="${p.stock_actuel}">${p.nom}</option>`).join('')}
            </select>
        </td>
        <td class="px-3 py-2 stock-dispo text-green-600 font-bold">-</td>
        <td class="px-3 py-2"><input type="number" name="produits[${index}][quantite]" min="1" value="1" class="w-20 border rounded px-2 py-1 text-sm quantite" oninput="calculerMontant(this)"></td>
        <td class="px-3 py-2"><input type="number" name="produits[${index}][prix_unitaire]" step="0.01" value="0" class="w-28 border rounded px-2 py-1 text-sm prix" oninput="calculerMontant(this)"></td>
        <td class="px-3 py-2"><input type="number" name="produits[${index}][remise]" min="0" max="100" value="0" class="w-16 border rounded px-2 py-1 text-sm remise" oninput="calculerMontant(this)"></td>
        <td class="px-3 py-2"><span class="montant font-bold">0</span></td>
        <td class="px-3 py-2"><button type="button" onclick="supprimerLigne(this)" class="text-red-500">✕</button></td>`;
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
    const row = el.closest('tr');
    const qte = parseFloat(row.querySelector('.quantite').value) || 0;
    const prix = parseFloat(row.querySelector('.prix').value) || 0;
    const remise = parseFloat(row.querySelector('.remise').value) || 0;
    const montant = qte * prix * (1 - remise / 100);
    row.querySelector('.montant').textContent = new Intl.NumberFormat('fr-FR').format(montant);
    calculerTotal();
}

function calculerTotal() {
    let total = 0;
    document.querySelectorAll('.ligne-row').forEach(row => {
        const qte = parseFloat(row.querySelector('.quantite').value) || 0;
        const prix = parseFloat(row.querySelector('.prix').value) || 0;
        const remise = parseFloat(row.querySelector('.remise').value) || 0;
        total += qte * prix * (1 - remise / 100);
    });
    document.getElementById('total').textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
}
</script>
@endsection
