@extends('layouts.app')
@section('title', 'Modifier facture fournisseur')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Modifier : {{ $facture->numero }}</h3>

    <form action="{{ route('appro.factures.update', $facture) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                <select name="fournisseur_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($fournisseurs as $f)
                        <option value="{{ $f->id }}" {{ old('fournisseur_id', $facture->fournisseur_id) == $f->id ? 'selected' : '' }}>
                            {{ $f->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bon de commande lié</label>
                <select name="bon_commande_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Aucun --</option>
                    @foreach($commandes as $bc)
                        <option value="{{ $bc->id }}" {{ old('bon_commande_id', $facture->bon_commande_id) == $bc->id ? 'selected' : '' }}>
                            {{ $bc->numero }} — {{ $bc->fournisseur->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date facture</label>
                <input type="date" name="date_facture"
                       value="{{ old('date_facture', $facture->date_facture->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date échéance</label>
                <input type="date" name="date_echeance"
                       value="{{ old('date_echeance', $facture->date_echeance?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant HT</label>
                <input type="number" name="montant_ht"
                       value="{{ old('montant_ht', $facture->montant_ht) }}"
                       step="0.01" id="montant_ht" oninput="calculerTTC()"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">TVA (%)</label>
                <input type="number" name="tva"
                       value="{{ old('tva', $facture->tva) }}"
                       step="0.01" min="0" max="100" id="tva" oninput="calculerTTC()"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-sm font-semibold text-blue-800">Montant TTC :
                <span id="montant_ttc" class="text-lg font-bold">
                    {{ number_format($facture->montant_ttc, 0, ',', ' ') }}
                </span> FCFA
            </p>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('appro.factures.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Mettre à jour</button>
        </div>
    </form>
</div>

<script>
function calculerTTC() {
    const ht = parseFloat(document.getElementById('montant_ht').value) || 0;
    const tva = parseFloat(document.getElementById('tva').value) || 0;
    document.getElementById('montant_ttc').textContent =
        new Intl.NumberFormat('fr-FR').format(ht * (1 + tva / 100));
}
</script>
@endsection
