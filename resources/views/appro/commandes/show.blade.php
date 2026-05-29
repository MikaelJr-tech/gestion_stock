@extends('layouts.app')
@section('title', 'Bon de commande ' . $commande->numero)

@section('content')
<div class="mb-4 flex justify-between items-center">
    <a href="{{ route('appro.commandes.index') }}" class="text-sm text-blue-600 hover:underline">← Retour</a>
    <div class="flex space-x-2">
        <a href="{{ route('appro.commandes.imprimer', $commande) }}" target="_blank"
           class="px-3 py-2 text-sm bg-green-600 text-white rounded-lg">🖨️ Imprimer BCF</a>
        <a href="{{ route('appro.commandes.imprimer-reception', $commande) }}" target="_blank"
           class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg">🖨️ Bon réception</a>
        <a href="{{ route('appro.commandes.edit', $commande) }}"
           class="px-3 py-2 text-sm bg-yellow-500 text-white rounded-lg">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-bold text-gray-800 mb-4">📋 {{ $commande->numero }}</h3>
        <div class="space-y-2 text-sm">
            <div><span class="text-gray-500">Fournisseur :</span> <span class="font-medium">{{ $commande->fournisseur->nom }}</span></div>
            <div><span class="text-gray-500">Date commande :</span> <span class="font-medium">{{ $commande->date_commande->format('d/m/Y') }}</span></div>
            <div><span class="text-gray-500">Date livraison :</span> <span class="font-medium">{{ $commande->date_livraison_prevue?->format('d/m/Y') ?? '-' }}</span></div>
            <div><span class="text-gray-500">Créé par :</span> <span class="font-medium">{{ $commande->user->name }}</span></div>
            <div><span class="text-gray-500">Statut :</span>
                <span class="px-2 py-1 rounded-full text-xs
                    {{ $commande->statut === 'reçu' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $commande->statut }}
                </span>
            </div>
            <div><span class="text-gray-500">Montant total :</span>
                <span class="font-bold text-blue-600 text-lg">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Produits commandés</h4>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">Produit</th>
                    <th class="px-3 py-2 text-left">Qté commandée</th>
                    <th class="px-3 py-2 text-left">Qté reçue</th>
                    <th class="px-3 py-2 text-left">Prix unitaire</th>
                    <th class="px-3 py-2 text-left">Montant</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($commande->lignes as $ligne)
                <tr>
                    <td class="px-3 py-2 font-medium">{{ $ligne->produit->nom }}</td>
                    <td class="px-3 py-2">{{ $ligne->quantite_commandee }} {{ $ligne->produit->unite }}</td>
                    <td class="px-3 py-2 {{ $ligne->quantite_recue < $ligne->quantite_commandee ? 'text-red-600' : 'text-green-600' }}">
                        {{ $ligne->quantite_recue }}
                    </td>
                    <td class="px-3 py-2">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td class="px-3 py-2 font-bold">{{ number_format($ligne->montant, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="4" class="px-3 py-2 text-right font-bold">TOTAL :</td>
                    <td class="px-3 py-2 font-bold text-blue-600">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
