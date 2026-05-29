@extends('layouts.app')
@section('title', 'Modifier bon de commande')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Modifier : {{ $commande->numero }}</h3>

    <form action="{{ route('appro.commandes.update', $commande) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                <select name="fournisseur_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach($fournisseurs as $f)
                        <option value="{{ $f->id }}" {{ old('fournisseur_id', $commande->fournisseur_id) == $f->id ? 'selected' : '' }}>
                            {{ $f->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date commande</label>
                <input type="date" name="date_commande" value="{{ old('date_commande', $commande->date_commande->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date livraison prévue</label>
                <input type="date" name="date_livraison_prevue"
                       value="{{ old('date_livraison_prevue', $commande->date_livraison_prevue?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <input type="text" name="notes" value="{{ old('notes', $commande->notes) }}"
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
                        <th class="px-3 py-2 text-left">Prix unitaire</th>
                        <th class="px-3 py-2 text-left">Montant</th>
                        <th class="px-3 py-2"></th>
                    </tr>
                </thead>
                <tbody id="lignes">
                    @foreach($commande->lignes as $i => $ligne)
                    <tr class="ligne-row">
                        <td class="px-3 py-2">
                            <select name="produits[{{ $i }}][produit_id]" class="w-full border rounded px-2 py-1 text-sm">
                                @foreach($produits as $p)
                                    <option value="{{ $p->id }}" {{ $ligne->produit_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[{{ $i }}][quantite]"
                                   value="{{ $ligne->quantite_commandee }}" min="1"
                                   class="w-24 border rounded px-2 py-1 text-sm quantite" oninput="calculerMontant(this)">
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" name="produits[{{ $i }}][prix_unitaire]"
                                   value="{{ $ligne->prix_unitaire }}" step="0.01"
                                   class="w-32 border rounded px-2 py-1 text-sm prix" oninput="calculerMontant(this)">
                        </td>
                        <td class="px-3 py-2">
                            <span class="montant font-bold">{{ number_format($ligne->montant, 0, ',', ' ') }}</span>
                        </td>
                        <td class="px-3 py-2">
                            <button type="button" onclick="supprimerLigne(this)" class="text-red-500">✕</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50">
                        <td colspan="3" class="px-3 py-2 text-right font-semibold">TOTAL :</td>
                        <td class="px-3 py-2 font-bold text-blue-600" id="total">
                            {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('appro.commandes.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Mettre à jour</button>
        </div>
    </form>
</div>

<script>
let index = {{ $commande->lignes->count() }};
const produits = @json($produits);

function ajouterLigne() {
    const tbody = document.getElementById('lignes');
    const tr = document.createElement('tr');
    tr.className = 'ligne-row';
    tr.innerHTML = `
        <td class="px-3 py-2">
            <select name="produits[${index}][produit_id]" class="w-full border rounded px-2 py-1 text-sm">
                <option value="">-- Produit --</option>
                ${produits.map(p => `<option value="${p.id}">${p.nom}</option>`).join('')}
            </select>
        </td>
        <td class="px-3 py-2">
            <input type="number" name="produits[${index}][quantite]" min="1" value="1"
                   class="w-24 border rounded px-2 py-1 text-sm quantite" oninput="calculerMontant(this)">
        </td>
        <td class="px-3 py-2">
            <input type="number" name="produits[${index}][prix_unitaire]" min="0" step="0.01" value="0"
                   class="w-32 border rounded px-2 py-1 text-sm prix" oninput="calculerMontant(this)">
        </td>
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
    row.querySelector('.montant').textContent = new Intl.NumberFormat('fr-FR').format(qte * prix);
    calculerTotal();
}

function calculerTotal() {
    let total = 0;
    document.querySelectorAll('.ligne-row').forEach(row => {
        const qte = parseFloat(row.querySelector('.quantite').value) || 0;
        const prix = parseFloat(row.querySelector('.prix').value) || 0;
        total += qte * prix;
    });
    document.getElementById('total').textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
}
</script>
@endsection
