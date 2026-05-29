@extends('layouts.app')
@section('title', 'Banques')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Liste des banques</h3>
    <a href="{{ route('banques.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouvelle banque
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">N° Compte</th>
                <th class="px-4 py-3 text-left">Solde</th>
                <th class="px-4 py-3 text-left">Versements</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($banques as $banque)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $banque->nom }}</td>
                <td class="px-4 py-3 font-mono text-xs">{{ $banque->numero_compte ?? '-' }}</td>
                <td class="px-4 py-3 font-bold text-green-600">
                    {{ number_format($banque->solde, 0, ',', ' ') }} FCFA
                </td>
                <td class="px-4 py-3">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                        {{ $banque->versements_count }}
                    </span>
                </td>
                <td class="px-4 py-3 flex space-x-2">
                    <a href="{{ route('banques.show', $banque) }}" class="text-blue-600 hover:underline">Voir</a>
                    <a href="{{ route('banques.edit', $banque) }}" class="text-yellow-600 hover:underline">Modifier</a>
                    <form action="{{ route('banques.destroy', $banque) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette banque ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucune banque enregistrée.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $banques->links() }}</div>
</div>
@endsection