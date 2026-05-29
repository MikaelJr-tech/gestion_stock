@extends('layouts.app')
@section('title', 'Modifier banque')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Modifier : {{ $banque->nom }}</h3>

    <form action="{{ route('banques.update', $banque) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input type="text" name="nom" value="{{ old('nom', $banque->nom) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de compte</label>
            <input type="text" name="numero_compte" value="{{ old('numero_compte', $banque->numero_compte) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('banques.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection