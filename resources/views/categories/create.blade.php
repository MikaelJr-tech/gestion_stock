@extends('layouts.app')
@section('title', 'Nouvelle catégorie')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Créer une catégorie client</h3>

    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="nom" value="{{ old('nom') }}"
                   placeholder="Ex: Grossiste, Détaillant..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Remise par défaut (%)</label>
            <input type="number" name="remise_default" value="{{ old('remise_default', 0) }}"
                   step="0.01" min="0" max="100"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('remise_default')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>
@endsection