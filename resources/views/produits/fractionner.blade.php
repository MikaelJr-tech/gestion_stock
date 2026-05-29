@extends('layouts.app')
@section('title', 'Fractionner ' . $produit->nom)

@section('content')
<div class="mb-4">
    <a href="{{ route('produits.show', $produit) }}" class="text-sm text-blue-600 hover:underline">← Retour au produit</a>
</div>

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Fractionner : {{ $produit->nom }}</h3>
    <p class="text-sm text-gray-500 mb-6">
        Stock actuel : <strong>{{ $produit->stock_actuel }} {{ $produit->unite }}</strong> —
        Facteur de fraction : <strong>{{ $produit->facteur_fraction }}</strong>
    </p>

    @if($fils->isEmpty())
        <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 text-sm text-yellow-800">
            ⚠️ Aucun produit fils défini pour ce produit père.
            <a href="{{ route('produits.create') }}" class="underline ml-1">Créer un produit fils</a>
        </div>
    @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Produit fils</th>
                    <th class="px-4 py-3 text-left">Stock actuel</th>
                    <th class="px-4 py-3 text-left">Unité</th>
                    <th class="px-4 py-3 text-left">Facteur</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($fils as $f)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $f->nom }}</td>
                    <td class="px-4 py-3 {{ $f->estEnRuptureDeStock() ? 'text-red-600 font-bold' : 'text-green-600' }}">
                        {{ $f->stock_actuel }}
                    </td>
                    <td class="px-4 py-3">{{ $f->unite }}</td>
                    <td class="px-4 py-3">{{ $f->facteur_fraction }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
