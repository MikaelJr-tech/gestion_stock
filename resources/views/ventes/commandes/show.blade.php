@extends('layouts.app')
@section('title', 'Commande ' . $commande->numero)

@section('content')
<div class="mb-4 flex justify-between">
    <a href="{{ route('ventes.commandes.index') }}" class="text-sm text-blue-600 hover:underline">← Retour</a>
    <div class="flex space-x-2">
        @if($commande->statut === 'en_attente')
        <form action="{{ route('ventes.commandes.livrer', $commande) }}" method="POST"
              onsubmit="return confirm('Confirmer la livraison ?')">
            @csrf
            <button class="px-3 py-2 text-sm bg-green-600 text-white rounded-lg">✅ Livrer</button>
        </form>
        @endif
        <a href="{{ route('ventes.commandes.imprimer', $commande) }}" target="_blank"
           class="px-3 py-2 text-sm bg-purple-600 text-white rounded-lg">🖨️ Bon commande</a>
        <a href="{{ route('ventes.commandes.imprimer-livraison', $commande) }}" target="_blank"
           class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg">🖨️ Bon livraison</a>
        <a href="{{ route('ventes.commandes.edit', $commande) }}"
           class="px-3 py-2 text-sm bg-yellow-500 text-white rounded-lg">Modifier</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6 space-y-3 text-sm">
        <h3 class="font-bold text-gray-800">🛒 {{ $commande->numero }}</h3>
        <div><span class="text-gray-500">Client :</span> <span class="font-medium">{{ $commande->client->nom }}</span></div>
        <div><span class="text-gray-500">Date :</span> <span class="font-medium">{{ $commande->date_commande->format('d/m/Y') }}</span></div>
        <div><span class="text-gray-500">Créé par :</span> <span class="font-medium">{{ $commande->user->name }}</span></div>
        <div><span class="text-gray-500">Statut :</span>
            <span class="px-2 py-1 rounded-full text-xs
                {{ $commande->statut === 'livrée' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $commande->statut }}
            </span>
        </div>
        <div><span class="text-gray-500">Montant total :</span>
            <span class="font-bold text-blue-600 text-lg">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Produits commandés</h4>
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
                @foreach($commande->lignes as $ligne)
                <tr>
                    <td class="px-3 py-2 font-medium">{{ $ligne->produit->nom }}</td>
                    <td class="px-3 py-2">{{ $ligne->quantite }} {{ $ligne->produit->unite }}</td>
                    <td class="px-3 py-2">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td class="px-3 py-2">{{ $ligne->remise }} %</td>
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
