@extends('layouts.app')
@section('title', 'Famille : ' . $famille->nom)

@section('content')
<div class="mb-4">
    <a href="{{ route('familles.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux familles</a>
</div>

<div class="bg-white rounded-xl shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ $famille->nom }}</h3>
    <p class="text-sm text-gray-500">{{ $famille->description ?? 'Aucune description.' }}</p>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h4 class="font-semibold text-gray-700">Produits de cette famille</h4>
        <a href="{{ route('produits.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">+ Ajouter</a>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Code</th>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Stock actuel</th>
                <th class="px-4 py-3 text-left">Prix vente</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($produits as $produit)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $produit->code }}</td>
                <td class="px-4 py-3">{{ $produit->nom }}</td>
                <td class="px-4 py-3 {{ $produit->estEnRuptureDeStock() ? 'text-red-600 font-bold' : '' }}">
                    {{ $produit->stock_actuel }} {{ $produit->unite }}
                </td>
                <td class="px-4 py-3">{{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA</td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Aucun produit dans cette famille.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $produits->links() }}</div>
</div>
@endsection