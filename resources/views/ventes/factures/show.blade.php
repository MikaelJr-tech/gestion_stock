@extends('layouts.app')
@section('title', 'Facture ' . $facture->numero)

@section('content')
<div class="mb-4 flex justify-between">
    <a href="{{ route('ventes.factures.index') }}" class="text-sm text-blue-600 hover:underline">← Retour</a>
    <a href="{{ route('ventes.factures.imprimer', $facture) }}" target="_blank"
       class="px-3 py-2 text-sm bg-green-600 text-white rounded-lg">🖨️ Imprimer</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6 space-y-3 text-sm">
        <h3 class="font-bold text-gray-800">{{ $facture->numero }}</h3>
        <div><span class="text-gray-500">Client :</span> <span class="font-medium">{{ $facture->client->nom }}</span></div>
        <div><span class="text-gray-500">Date :</span> <span class="font-medium">{{ $facture->date_facture->format('d/m/Y') }}</span></div>
        <div><span class="text-gray-500">Type vente :</span>
            <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">{{ $facture->type_vente }}</span>
        </div>
        <div><span class="text-gray-500">Montant HT :</span> <span class="font-medium">{{ number_format($facture->montant_ht, 0, ',', ' ') }} FCFA</span></div>
        <div><span class="text-gray-500">TVA :</span> <span class="font-medium">{{ $facture->tva }} %</span></div>
        <div><span class="text-gray-500">Montant TTC :</span> <span class="font-bold text-blue-600 text-lg">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</span></div>
        <div><span class="text-gray-500">Réglé :</span> <span class="text-green-600 font-bold">{{ number_format($facture->montant_regle, 0, ',', ' ') }} FCFA</span></div>
        <div><span class="text-gray-500">Reste :</span> <span class="text-red-600 font-bold">{{ number_format($facture->resteAPayer(), 0, ',', ' ') }} FCFA</span></div>

        @if($facture->resteAPayer() > 0)
        <form action="{{ route('ventes.factures.regler', $facture) }}" method="POST" class="pt-4 space-y-2">
            @csrf
            <label class="block text-sm font-medium text-gray-700">Régler un montant</label>
            <input type="number" name="montant_regle" step="0.01" min="0" max="{{ $facture->resteAPayer() }}"
                   placeholder="Montant à régler"
                   class="w-full border rounded-lg px-3 py-2 text-sm">
            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                ✅ Enregistrer règlement
            </button>
        </form>
        @endif
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Produits facturés</h4>
        @if($facture->commande)
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">Produit</th>
                    <th class="px-3 py-2 text-left">Quantité</th>
                    <th class="px-3 py-2 text-left">Prix unitaire</th>
                    <th class="px-3 py-2 text-left">Remise</th>
                    <th class="px-3 py-2 text-left">Montant</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($facture->commande->lignes as $ligne)
                <tr>
                    <td class="px-3 py-2">{{ $ligne->produit->nom }}</td>
                    <td class="px-3 py-2">{{ $ligne->quantite }}</td>
                    <td class="px-3 py-2">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td class="px-3 py-2">{{ $ligne->remise }} %</td>
                    <td class="px-3 py-2 font-bold">{{ number_format($ligne->montant, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-sm text-gray-400">Facture vente comptant directe.</p>
        @endif
    </div>
</div>
@endsection
