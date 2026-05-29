@extends('layouts.app')
@section('title', 'Produits')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Liste des produits</h3>
    <a href="{{ route('produits.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouveau produit
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Code</th>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Famille</th>
                <th class="px-4 py-3 text-left">Stock</th>
                <th class="px-4 py-3 text-left">Prix achat</th>
                <th class="px-4 py-3 text-left">Prix vente</th>
                <th class="px-4 py-3 text-left">Type</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($produits as $produit)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $produit->code }}</td>
                <td class="px-4 py-3 font-medium">{{ $produit->nom }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $produit->famille->nom ?? '-' }}</td>
                <td class="px-4 py-3">
                    <span class="{{ $produit->estEnRuptureDeStock() ? 'text-red-600 font-bold' : 'text-green-600' }}">
                        {{ $produit->stock_actuel }} {{ $produit->unite }}
                    </span>
                </td>
                <td class="px-4 py-3">{{ number_format($produit->prix_achat, 0, ',', ' ') }}</td>
                <td class="px-4 py-3">{{ number_format($produit->prix_vente, 0, ',', ' ') }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">{{ $produit->type }}</span>
                </td>
                <td class="px-4 py-3 flex space-x-2">
                    <a href="{{ route('produits.show', $produit) }}" class="text-blue-600 hover:underline">Voir</a>
                    <a href="{{ route('produits.edit', $produit) }}" class="text-yellow-600 hover:underline">Modifier</a>
                    <form action="{{ route('produits.destroy', $produit) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce produit ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-6 text-center text-gray-400">Aucun produit enregistré.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $produits->links() }}</div>
</div>
@endsection