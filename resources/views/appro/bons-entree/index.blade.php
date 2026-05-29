@extends('layouts.app')
@section('title', 'Bons d\'entrée')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Bons d'entrée / Dons</h3>
    <a href="{{ route('appro.bons-entree.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouveau bon d'entrée
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Numéro</th>
                <th class="px-4 py-3 text-left">Type</th>
                <th class="px-4 py-3 text-left">Source</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Créé par</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($bons as $bon)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs font-bold">{{ $bon->numero }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $bon->type === 'don' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $bon->type }}
                    </span>
                </td>
                <td class="px-4 py-3">{{ $bon->source ?? '-' }}</td>
                <td class="px-4 py-3">{{ $bon->date_entree->format('d/m/Y') }}</td>
                <td class="px-4 py-3">{{ $bon->user->name }}</td>
                <td class="px-4 py-3">
                    <div class="flex space-x-2">
                        <a href="{{ route('appro.bons-entree.show', $bon) }}" class="text-blue-600 hover:underline">Voir</a>
                        <a href="{{ route('appro.bons-entree.imprimer', $bon) }}" target="_blank" class="text-green-600 hover:underline">PDF</a>
                        <form action="{{ route('appro.bons-entree.destroy', $bon) }}" method="POST"
                              onsubmit="return confirm('Supprimer ce bon d\'entrée ? Le stock sera mis à jour.')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Aucun bon d'entrée.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $bons->links() }}</div>
</div>
@endsection
