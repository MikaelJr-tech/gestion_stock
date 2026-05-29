@extends('layouts.app')
@section('title', 'Détail versement')

@section('content')
<div class="mb-4">
    <a href="{{ route('versements.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux versements</a>
</div>

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-6">💰 Détail du versement</h3>

    <div class="space-y-4 text-sm">
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-500">Banque</span>
            <span class="font-medium">{{ $versement->banque->nom }}</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-500">Montant</span>
            <span class="font-bold text-green-600 text-lg">
                {{ number_format($versement->montant, 0, ',', ' ') }} FCFA
            </span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-500">Date de versement</span>
            <span class="font-medium">{{ $versement->date_versement->format('d/m/Y') }}</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-500">Référence</span>
            <span class="font-mono text-xs">{{ $versement->reference ?? '-' }}</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-500">Enregistré par</span>
            <span class="font-medium">{{ $versement->user->name ?? '-' }}</span>
        </div>
        <div class="flex justify-between pb-3">
            <span class="text-gray-500">Notes</span>
            <span class="font-medium text-right max-w-xs">{{ $versement->notes ?? '-' }}</span>
        </div>
    </div>

    <div class="flex space-x-3 mt-6">
        <a href="{{ route('versements.edit', $versement) }}"
           class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
            Modifier
        </a>
        <form action="{{ route('versements.destroy', $versement) }}" method="POST"
              onsubmit="return confirm('Supprimer ce versement ?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
                Supprimer
            </button>
        </form>
    </div>
</div>
@endsection