@extends('layouts.app')
@section('title', 'Versements banque')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Versements en banque</h3>
    <a href="{{ route('versements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouveau versement
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Banque</th>
                <th class="px-4 py-3 text-left">Montant</th>
                <th class="px-4 py-3 text-left">Référence</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($versements as $versement)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $versement->date_versement->format('d/m/Y') }}</td>
                <td class="px-4 py-3 font-medium">{{ $versement->banque->nom }}</td>
                <td class="px-4 py-3 font-bold text-green-600">
                    {{ number_format($versement->montant, 0, ',', ' ') }} FCFA
                </td>
                <td class="px-4 py-3 font-mono text-xs">{{ $versement->reference ?? '-' }}</td>
                <td class="px-4 py-3 flex space-x-2">
                    <a href="{{ route('versements.edit', $versement) }}" class="text-yellow-600 hover:underline">Modifier</a>
                    <form action="{{ route('versements.destroy', $versement) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce versement ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun versement enregistré.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $versements->links() }}</div>
</div>
@endsection