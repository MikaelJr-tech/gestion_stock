@extends('layouts.app')
@section('title', 'Modifier catégorie')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Modifier : {{ $category->nom }}</h3>

    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input type="text" name="nom" value="{{ old('nom', $category->nom) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Remise par défaut (%)</label>
            <input type="number" name="remise_default" value="{{ old('remise_default', $category->remise_default) }}"
                   step="0.01" min="0" max="100"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection