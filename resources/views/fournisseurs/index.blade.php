@extends('layouts.app')
@section('title', 'Fournisseurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Liste des fournisseurs</h3>
    <a href="{{ route('fournisseurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouveau fournisseur
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Téléphone</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">N° Contribuable</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($fournisseurs as $fournisseur)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $fournisseur->nom }}</td>
                <td class="px-4 py-3">{{ $fournisseur->telephone ?? '-' }}</td>
                <td class="px-4 py-3">{{ $fournisseur->email ?? '-' }}</td>
                <td class="px-4 py-3">{{ $fournisseur->numero_contribuable ?? '-' }}</td>
                <td class="px-4 py-3 flex space-x-2">
                    <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="text-yellow-600 hover:underline">Modifier</a>
                    <form action="{{ route('fournisseurs.destroy', $fournisseur) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce fournisseur ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun fournisseur enregistré.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $fournisseurs->links() }}</div>
</div>
@endsection