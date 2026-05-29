@extends('layouts.app')
@section('title', 'Clients')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Liste des clients</h3>
    <a href="{{ route('clients.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouveau client
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Catégorie</th>
                <th class="px-4 py-3 text-left">Téléphone</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Solde</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($clients as $client)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $client->nom }}</td>
                <td class="px-4 py-3">
                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">
                        {{ $client->categorie->nom ?? '-' }}
                    </span>
                </td>
                <td class="px-4 py-3">{{ $client->telephone ?? '-' }}</td>
                <td class="px-4 py-3">{{ $client->email ?? '-' }}</td>
                <td class="px-4 py-3 {{ $client->solde < 0 ? 'text-red-600' : 'text-green-600' }} font-medium">
                    {{ number_format($client->solde, 0, ',', ' ') }} FCFA
                </td>
                <td class="px-4 py-3 flex space-x-2">
                    <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:underline">Voir</a>
                    <a href="{{ route('clients.edit', $client) }}" class="text-yellow-600 hover:underline">Modifier</a>
                    <form action="{{ route('clients.destroy', $client) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce client ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Aucun client enregistré.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $clients->links() }}</div>
</div>
@endsection