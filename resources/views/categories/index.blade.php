@extends('layouts.app')
@section('title', 'Catégories clients')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Catégories de clients</h3>
    <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouvelle catégorie
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Remise par défaut</th>
                <th class="px-4 py-3 text-left">Nb clients</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $cat)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $cat->nom }}</td>
                <td class="px-4 py-3">{{ $cat->remise_default }} %</td>
                <td class="px-4 py-3">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                        {{ $cat->clients_count }}
                    </span>
                </td>
                <td class="px-4 py-3 flex space-x-2">
                    <a href="{{ route('categories.edit', $cat) }}" class="text-yellow-600 hover:underline">Modifier</a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette catégorie ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Aucune catégorie.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $categories->links() }}</div>
</div>
@endsection