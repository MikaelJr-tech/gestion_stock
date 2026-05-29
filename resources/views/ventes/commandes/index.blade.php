@extends('layouts.app')
@section('title', 'Commandes clients')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Commandes clients</h3>
    <a href="{{ route('ventes.commandes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouvelle commande
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Numéro</th>
                <th class="px-4 py-3 text-left">Client</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Montant</th>
                <th class="px-4 py-3 text-left">Statut</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($commandes as $commande)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs font-bold">{{ $commande->numero }}</td>
                <td class="px-4 py-3 font-medium">{{ $commande->client->nom }}</td>
                <td class="px-4 py-3">{{ $commande->date_commande->format('d/m/Y') }}</td>
                <td class="px-4 py-3 font-bold">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $commande->statut === 'livrée' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $commande->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $commande->statut === 'annulée' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $commande->statut === 'partielle' ? 'bg-blue-100 text-blue-700' : '' }}">
                        {{ $commande->statut }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex space-x-2">
                        <a href="{{ route('ventes.commandes.show', $commande) }}" class="text-blue-600 hover:underline">Voir</a>
                        @if($commande->statut === 'en_attente')
                        <form action="{{ route('ventes.commandes.livrer', $commande) }}" method="POST"
                              onsubmit="return confirm('Confirmer la livraison ?')">
                            @csrf
                            <button class="text-green-600 hover:underline">Livrer</button>
                        </form>
                        @endif
                        <a href="{{ route('ventes.commandes.imprimer', $commande) }}" target="_blank" class="text-purple-600 hover:underline">PDF</a>
                        <form action="{{ route('ventes.commandes.destroy', $commande) }}" method="POST"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Aucune commande.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $commandes->links() }}</div>
</div>
@endsection
