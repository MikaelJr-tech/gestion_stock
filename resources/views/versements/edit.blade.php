@extends('layouts.app')
@section('title', 'Modifier versement')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Modifier le versement</h3>

    <form action="{{ route('versements.update', $versement) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Banque</label>
            <select name="banque_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                @foreach($banques as $banque)
                    <option value="{{ $banque->id }}" {{ old('banque_id', $versement->banque_id) == $banque->id ? 'selected' : '' }}>
                        {{ $banque->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
            <input type="number" name="montant" value="{{ old('montant', $versement->montant) }}" step="0.01"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date de versement</label>
            <input type="date" name="date_versement" value="{{ old('date_versement', $versement->date_versement->format('Y-m-d')) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
            <input type="text" name="reference" value="{{ old('reference', $versement->reference) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $versement->notes) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('versements.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection