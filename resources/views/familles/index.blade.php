@extends('layouts.app')
@section('title', 'Familles de produits')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Liste des familles</h3>
    <a href="{{ route('familles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouvelle famille
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Description</th>
                <th class="px-4 py-3 text-left">Nb produits</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($familles as $famille)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $famille->id }}</td>
                <td class="px-4 py-3 font-medium">{{ $famille->nom }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $famille->description ?? '-' }}</td>
                <td class="px-4 py-3">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                        {{ $famille->produits_count }}
                    </span>
                </td>
                <td class="px-4 py-3 flex space-x-2">
                    <a href="{{ route('familles.show', $famille) }}" class="text-blue-600 hover:underline">Voir</a>
                    <a href="{{ route('familles.edit', $famille) }}" class="text-yellow-600 hover:underline">Modifier</a>
                    <form action="{{ route('familles.destroy', $famille) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette famille ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucune famille enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $familles->links() }}</div>
</div>
@endsection
