@extends('layouts.app')
@section('title', 'Nouveau produit')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Créer un produit</h3>

    <form action="{{ route('produits.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                <input type="text" name="nom" value="{{ old('nom') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Famille <span class="text-red-500">*</span></label>
                <select name="famille_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Choisir --</option>
                    @foreach($familles as $famille)
                        <option value="{{ $famille->id }}" {{ old('famille_id') == $famille->id ? 'selected' : '' }}>
                            {{ $famille->nom }}
                        </option>
                    @endforeach
                </select>
                @error('famille_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unité <span class="text-red-500">*</span></label>
                <input type="text" name="unite" value="{{ old('unite') }}" placeholder="kg, litre, pièce..."
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('unite')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix achat <span class="text-red-500">*</span></label>
                <input type="number" name="prix_achat" value="{{ old('prix_achat', 0) }}" step="0.01"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix vente <span class="text-red-500">*</span></label>
                <input type="number" name="prix_vente" value="{{ old('prix_vente', 0) }}" step="0.01"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock minimum <span class="text-red-500">*</span></label>
                <input type="number" name="stock_minimum" value="{{ old('stock_minimum', 0) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="simple" {{ old('type') == 'simple' ? 'selected' : '' }}>Simple</option>
                    <option value="père" {{ old('type') == 'père' ? 'selected' : '' }}>Père (produit parent)</option>
                    <option value="fils" {{ old('type') == 'fils' ? 'selected' : '' }}>Fils (produit enfant)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Produit parent (si fils)</label>
                <select name="produit_parent_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Aucun --</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('produit_parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Facteur de fraction</label>
                <input type="number" name="facteur_fraction" value="{{ old('facteur_fraction', 1) }}" step="0.0001"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date d'expiration</label>
            <input type="date" name="date_expiration" value="{{ old('date_expiration') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('produits.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection