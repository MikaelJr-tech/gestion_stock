@extends('layouts.app')
@section('title', $fournisseur->nom)

@section('content')
<div class="mb-4">
    <a href="{{ route('fournisseurs.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux fournisseurs</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🏭 {{ $fournisseur->nom }}</h3>
        <div class="space-y-2 text-sm">
            <div><span class="text-gray-500">Téléphone :</span> <span class="font-medium">{{ $fournisseur->telephone ?? '-' }}</span></div>
            <div><span class="text-gray-500">Email :</span> <span class="font-medium">{{ $fournisseur->email ?? '-' }}</span></div>
            <div><span class="text-gray-500">Adresse :</span> <span class="font-medium">{{ $fournisseur->adresse ?? '-' }}</span></div>
            <div><span class="text-gray-500">N° Contribuable :</span> <span class="font-medium">{{ $fournisseur->numero_contribuable ?? '-' }}</span></div>
        </div>
        <a href="{{ route('fournisseurs.edit', $fournisseur) }}"
           class="mt-4 inline-block px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg">Modifier</a>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-semibold text-gray-700">Bons de commande</h4>
                <a href="{{ route('appro.commandes.create') }}" class="text-sm text-blue-600 hover:underline">+ Nouveau</a>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-3 py-2 text-left">Numéro</th>
                        <th class="px-3 py-2 text-left">Date</th>
                        <th class="px-3 py-2 text-left">Montant</th>
                        <th class="px-3 py-2 text-left">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($fournisseur->bonsCommande->take(5) as $bc)
                    <tr>
                        <td class="px-3 py-2 font-mono text-xs">{{ $bc->numero }}</td>
                        <td class="px-3 py-2">{{ $bc->date_commande->format('d/m/Y') }}</td>
                        <td class="px-3 py-2 font-bold">{{ number_format($bc->montant_total, 0, ',', ' ') }} FCFA</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">{{ $bc->statut }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-3 py-4 text-center text-gray-400">Aucune commande.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-4">Factures fournisseur</h4>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-3 py-2 text-left">Numéro</th>
                        <th class="px-3 py-2 text-left">Date</th>
                        <th class="px-3 py-2 text-left">Montant TTC</th>
                        <th class="px-3 py-2 text-left">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($fournisseur->factures->take(5) as $facture)
                    <tr>
                        <td class="px-3 py-2 font-mono text-xs">{{ $facture->numero }}</td>
                        <td class="px-3 py-2">{{ $facture->date_facture->format('d/m/Y') }}</td>
                        <td class="px-3 py-2 font-bold">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $facture->statut === 'réglée' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $facture->statut }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-3 py-4 text-center text-gray-400">Aucune facture.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
