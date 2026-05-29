@extends('layouts.app')
@section('title', $produit->nom)

@section('content')
<div class="mb-4">
    <a href="{{ route('produits.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux produits</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ $produit->nom }}</h3>
                <p class="text-sm text-gray-500 font-mono">{{ $produit->code }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">{{ $produit->type }}</span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="text-gray-500">Famille :</span> <span class="font-medium">{{ $produit->famille->nom ?? '-' }}</span></div>
            <div><span class="text-gray-500">Unité :</span> <span class="font-medium">{{ $produit->unite }}</span></div>
            <div><span class="text-gray-500">Prix achat :</span> <span class="font-medium">{{ number_format($produit->prix_achat, 0, ',', ' ') }} FCFA</span></div>
            <div><span class="text-gray-500">Prix vente :</span> <span class="font-medium">{{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA</span></div>
            <div><span class="text-gray-500">Stock actuel :</span>
                <span class="font-bold {{ $produit->estEnRuptureDeStock() ? 'text-red-600' : 'text-green-600' }}">
                    {{ $produit->stock_actuel }} {{ $produit->unite }}
                </span>
            </div>
            <div><span class="text-gray-500">Stock minimum :</span> <span class="font-medium">{{ $produit->stock_minimum }}</span></div>
            @if($produit->date_expiration)
            <div><span class="text-gray-500">Date expiration :</span> <span class="font-medium">{{ $produit->date_expiration->format('d/m/Y') }}</span></div>
            @endif
        </div>

        <div class="flex space-x-3 mt-6">
            <a href="{{ route('produits.edit', $produit) }}" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg">Modifier</a>
            @if($produit->type === 'père')
            <a href="{{ route('produits.fractionner', $produit) }}" class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg">Fractionner</a>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Produits fils</h4>
        @forelse($produit->produitsFils as $fils)
        <div class="text-sm py-2 border-b">
            <p class="font-medium">{{ $fils->nom }}</p>
            <p class="text-gray-500">Stock : {{ $fils->stock_actuel }} {{ $fils->unite }}</p>
        </div>
        @empty
        <p class="text-sm text-gray-400">Aucun produit fils.</p>
        @endforelse
    </div>
</div>
@endsection