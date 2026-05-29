@extends('layouts.app')
@section('title', 'Modifier produit')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Modifier : {{ $produit->nom }}</h3>

    <form action="{{ route('produits.update', $produit) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                <input type="text" name="code" value="{{ old('code', $produit->code) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $produit->nom) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Famille</label>
                <select name="famille_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @foreach($familles as $famille)
                        <option value="{{ $famille->id }}" {{ old('famille_id', $produit->famille_id) == $famille->id ? 'selected' : '' }}>
                            {{ $famille->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unité</label>
                <input type="text" name="unite" value="{{ old('unite', $produit->unite) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix achat</label>
                <input type="number" name="prix_achat" value="{{ old('prix_achat', $produit->prix_achat) }}" step="0.01"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix vente</label>
                <input type="number" name="prix_vente" value="{{ old('prix_vente', $produit->prix_vente) }}" step="0.01"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock minimum</label>
                <input type="number" name="stock_minimum" value="{{ old('stock_minimum', $produit->stock_minimum) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="simple" {{ old('type', $produit->type) == 'simple' ? 'selected' : '' }}>Simple</option>
                    <option value="père" {{ old('type', $produit->type) == 'père' ? 'selected' : '' }}>Père</option>
                    <option value="fils" {{ old('type', $produit->type) == 'fils' ? 'selected' : '' }}>Fils</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date d'expiration</label>
            <input type="date" name="date_expiration" value="{{ old('date_expiration', $produit->date_expiration?->format('Y-m-d')) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('produits.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection