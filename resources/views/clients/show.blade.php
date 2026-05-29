@extends('layouts.app')
@section('title', $client->nom)

@section('content')
<div class="mb-4">
    <a href="{{ route('clients.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux clients</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">{{ $client->nom }}</h3>
        <div class="space-y-2 text-sm">
            <div><span class="text-gray-500">Catégorie :</span> <span class="font-medium">{{ $client->categorie->nom ?? '-' }}</span></div>
            <div><span class="text-gray-500">Téléphone :</span> <span class="font-medium">{{ $client->telephone ?? '-' }}</span></div>
            <div><span class="text-gray-500">Email :</span> <span class="font-medium">{{ $client->email ?? '-' }}</span></div>
            <div><span class="text-gray-500">Adresse :</span> <span class="font-medium">{{ $client->adresse ?? '-' }}</span></div>
            <div><span class="text-gray-500">Solde :</span>
                <span class="font-bold {{ $client->solde < 0 ? 'text-red-600' : 'text-green-600' }}">
                    {{ number_format($client->solde, 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>
        <a href="{{ route('clients.edit', $client) }}" class="mt-4 inline-block px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg">Modifier</a>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-4">Dernières commandes</h4>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-3 py-2 text-left">N°</th>
                        <th class="px-3 py-2 text-left">Date</th>
                        <th class="px-3 py-2 text-left">Montant</th>
                        <th class="px-3 py-2 text-left">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($client->commandes->take(5) as $commande)
                    <tr>
                        <td class="px-3 py-2">{{ $commande->numero }}</td>
                        <td class="px-3 py-2">{{ $commande->date_commande->format('d/m/Y') }}</td>
                        <td class="px-3 py-2">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $commande->statut === 'livrée' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $commande->statut }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-3 py-4 text-center text-gray-400">Aucune commande.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection