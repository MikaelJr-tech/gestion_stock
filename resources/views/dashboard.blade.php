@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    {{-- Carte : Total produits --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-blue-100 text-blue-600 rounded-full p-4 text-2xl">📦</div>
        <div>
            <p class="text-sm text-gray-500">Total produits</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_produits'] }}</p>
        </div>
    </div>

    {{-- Carte : Rupture de stock --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-red-100 text-red-600 rounded-full p-4 text-2xl">⚠️</div>
        <div>
            <p class="text-sm text-gray-500">Rupture de stock</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['produits_rupture'] }}</p>
        </div>
    </div>

    {{-- Carte : Commandes en attente --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-yellow-100 text-yellow-600 rounded-full p-4 text-2xl">🛒</div>
        <div>
            <p class="text-sm text-gray-500">Commandes en attente</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['commandes_en_attente'] }}</p>
        </div>
    </div>

    {{-- Carte : Factures clients impayées --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-orange-100 text-orange-600 rounded-full p-4 text-2xl">🧾</div>
        <div>
            <p class="text-sm text-gray-500">Factures clients impayées</p>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['factures_impayees'] }}</p>
        </div>
    </div>

    {{-- Carte : Factures fournisseur impayées --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-purple-100 text-purple-600 rounded-full p-4 text-2xl">🏭</div>
        <div>
            <p class="text-sm text-gray-500">Factures fournisseur impayées</p>
            <p class="text-2xl font-bold text-purple-600">{{ $stats['factures_fournisseur'] }}</p>
        </div>
    </div>

    {{-- Carte : Commandes fournisseur en attente --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-green-100 text-green-600 rounded-full p-4 text-2xl">📋</div>
        <div>
            <p class="text-sm text-gray-500">Commandes fournisseur en attente</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['commandes_fournisseur'] }}</p>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Produits en rupture --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-base font-semibold text-gray-700 mb-4">⚠️ Produits en rupture de stock</h3>
        @if($produitsRupture->isEmpty())
            <p class="text-sm text-gray-400">Aucun produit en rupture.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-2">Produit</th>
                        <th class="pb-2">Stock actuel</th>
                        <th class="pb-2">Stock minimum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produitsRupture as $produit)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">{{ $produit->nom }}</td>
                        <td class="py-2 text-red-600 font-bold">{{ $produit->stock_actuel }}</td>
                        <td class="py-2">{{ $produit->stock_minimum }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Dernières commandes --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-base font-semibold text-gray-700 mb-4">🛒 Dernières commandes clients</h3>
        @if($dernieresCommandes->isEmpty())
            <p class="text-sm text-gray-400">Aucune commande enregistrée.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-2">N°</th>
                        <th class="pb-2">Client</th>
                        <th class="pb-2">Montant</th>
                        <th class="pb-2">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dernieresCommandes as $commande)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">{{ $commande->numero }}</td>
                        <td class="py-2">{{ $commande->client->nom }}</td>
                        <td class="py-2">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $commande->statut === 'livrée' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $commande->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $commande->statut === 'annulée' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $commande->statut }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
