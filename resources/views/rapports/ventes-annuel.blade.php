@extends('layouts.app')
@section('title', 'État des ventes annuel')

@section('content')
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form method="GET" class="flex items-end space-x-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Année</label>
            <select name="annee" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $annee == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">🔍 Filtrer</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between">
        <h3 class="font-semibold text-gray-700">Ventes de l'année {{ $annee }}</h3>
        <span class="text-lg font-bold text-green-600">Total : {{ number_format($total, 0, ',', ' ') }} FCFA</span>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Numéro</th>
                <th class="px-4 py-3 text-left">Client</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Type</th>
                <th class="px-4 py-3 text-left">Montant TTC</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($factures as $facture)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $facture->numero }}</td>
                <td class="px-4 py-3">{{ $facture->client->nom }}</td>
                <td class="px-4 py-3">{{ $facture->date_facture->format('d/m/Y') }}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">{{ $facture->type_vente }}</span></td>
                <td class="px-4 py-3 font-bold">{{ number_format($facture->montant_ttc, 0, ',', ' ') }} FCFA</td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucune vente pour cette année.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
