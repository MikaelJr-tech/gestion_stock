@extends('layouts.app')
@section('title', 'Factures fournisseur')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Factures fournisseur</h3>
    <a href="{{ route('appro.factures.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouvelle facture
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Numéro</th>
                <th class="px-4 py-3 text-left">Fournisseur</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Montant TTC</th>
                <th class="px-4 py-3 text-left">Réglé</th>
                <th class="px-4 py-3 text-left">Reste</th>
                <th class="px-4 py-3 text-left">Statut</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($factures as $facture)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs font-bold">{{ $facture->numero }}</td>
                <td class="px-4 py-3">{{ $facture->fournisseur->nom }}</td>
                <td class="px-4 py-3">{{ $facture->date_facture->format('d/m/Y') }}</td>
                <td class="px-4 py-3 font-bold">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td>
                <td class="px-4 py-3 text-green-600">{{ number_format($facture->montant_regle, 0, ',', ' ') }} FCFA</td>
                <td class="px-4 py-3 text-red-600 font-bold">{{ number_format($facture->resteAPayer(), 0, ',', ' ') }} FCFA</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $facture->statut === 'réglée' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $facture->statut === 'impayée' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $facture->statut === 'partielle' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ $facture->statut }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex space-x-2">
                        <a href="{{ route('appro.factures.show', $facture) }}" class="text-blue-600 hover:underline">Voir</a>
                        <a href="{{ route('appro.factures.imprimer', $facture) }}" target="_blank" class="text-green-600 hover:underline">PDF</a>
                        <form action="{{ route('appro.factures.destroy', $facture) }}" method="POST"
                              onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-4 py-6 text-center text-gray-400">Aucune facture fournisseur.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $factures->links() }}</div>
</div>
@endsection
