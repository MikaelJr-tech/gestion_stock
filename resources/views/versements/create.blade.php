@extends('layouts.app')
@section('title', 'Nouveau versement')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Enregistrer un versement</h3>

    <form action="{{ route('versements.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Banque <span class="text-red-500">*</span></label>
            <select name="banque_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Choisir --</option>
                @foreach($banques as $banque)
                    <option value="{{ $banque->id }}" {{ old('banque_id') == $banque->id ? 'selected' : '' }}>
                        {{ $banque->nom }} — {{ number_format($banque->solde, 0, ',', ' ') }} FCFA
                    </option>
                @endforeach
            </select>
            @error('banque_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Montant <span class="text-red-500">*</span></label>
            <input type="number" name="montant" value="{{ old('montant') }}" step="0.01" min="0"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('montant')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date de versement <span class="text-red-500">*</span></label>
            <input type="date" name="date_versement" value="{{ old('date_versement', today()->toDateString()) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('date_versement')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
            <input type="text" name="reference" value="{{ old('reference') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea name="notes" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('versements.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>
@endsection