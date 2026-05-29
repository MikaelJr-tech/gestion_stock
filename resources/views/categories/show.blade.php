@extends('layouts.app')
@section('title', $category->nom)

@section('content')
<div class="mb-4">
    <a href="{{ route('categories.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux catégories</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🏷️ {{ $category->nom }}</h3>
        <div class="space-y-2 text-sm">
            <div><span class="text-gray-500">Remise par défaut :</span>
                <span class="font-bold text-blue-600">{{ $category->remise_default }} %</span>
            </div>
            <div><span class="text-gray-500">Nombre de clients :</span>
                <span class="font-bold">{{ $clients->total() }}</span>
            </div>
        </div>
        <a href="{{ route('categories.edit', $category) }}"
           class="mt-4 inline-block px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg">Modifier</a>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Clients de cette catégorie</h4>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">Nom</th>
                    <th class="px-3 py-2 text-left">Téléphone</th>
                    <th class="px-3 py-2 text-left">Solde</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($clients as $client)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 font-medium">{{ $client->nom }}</td>
                    <td class="px-3 py-2">{{ $client->telephone ?? '-' }}</td>
                    <td class="px-3 py-2 {{ $client->solde < 0 ? 'text-red-600' : 'text-green-600' }} font-bold">
                        {{ number_format($client->solde, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-3 py-4 text-center text-gray-400">Aucun client dans cette catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $clients->links() }}</div>
    </div>
</div>
@endsection
