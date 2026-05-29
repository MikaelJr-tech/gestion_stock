@extends('layouts.app')
@section('title', 'Bon d\'entrée ' . $bonEntree->numero)

@section('content')
<div class="mb-4 flex justify-between">
    <a href="{{ route('appro.bons-entree.index') }}" class="text-sm text-blue-600 hover:underline">← Retour</a>
    <a href="{{ route('appro.bons-entree.imprimer', $bonEntree) }}" target="_blank"
       class="px-3 py-2 text-sm bg-green-600 text-white rounded-lg">🖨️ Imprimer</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6 space-y-3 text-sm">
        <h3 class="font-bold text-gray-800">📥 {{ $bonEntree->numero }}</h3>
        <div><span class="text-gray-500">Type :</span>
            <span class="px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-700">{{ $bonEntree->type }}</span>
        </div>
        <div><span class="text-gray-500">Source :</span> <span class="font-medium">{{ $bonEntree->source ?? '-' }}</span></div>
        <div><span class="text-gray-500">Date :</span> <span class="font-medium">{{ $bonEntree->date_entree->format('d/m/Y') }}</span></div>
        <div><span class="text-gray-500">Créé par :</span> <span class="font-medium">{{ $bonEntree->user->name }}</span></div>
        <div><span class="text-gray-500">Notes :</span> <span class="font-medium">{{ $bonEntree->notes ?? '-' }}</span></div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Produits entrés</h4>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">Produit</th>
                    <th class="px-3 py-2 text-left">Quantité</th>
                    <th class="px-3 py-2 text-left">Valeur unitaire</th>
                    <th class="px-3 py-2 text-left">Valeur totale</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($bonEntree->lignes as $ligne)
                <tr>
                    <td class="px-3 py-2 font-medium">{{ $ligne->produit->nom }}</td>
                    <td class="px-3 py-2">{{ $ligne->quantite }} {{ $ligne->produit->unite }}</td>
                    <td class="px-3 py-2">{{ number_format($ligne->valeur_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td class="px-3 py-2 font-bold">{{ number_format($ligne->quantite * $ligne->valeur_unitaire, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
