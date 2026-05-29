@extends('layouts.app')
@section('title', 'État des achats par jour')

@section('content')
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form method="GET" class="flex items-end space-x-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input type="date" name="date" value="{{ $date }}"
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">🔍 Filtrer</button>
        <a href="{{ route('rapports.imprimer-achats-jour', ['date' => $date]) }}" target="_blank"
           class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm">🖨️ Imprimer</a>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h3 class="font-semibold text-gray-700">Achats du {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h3>
        <span class="text-lg font-bold text-blue-600">Total : {{ number_format($total, 0, ',', ' ') }} FCFA</span>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Numéro BCF</th>
                <th class="px-4 py-3 text-left">Fournisseur</th>
                <th class="px-4 py-3 text-left">Statut</th>
                <th class="px-4 py-3 text-left">Montant</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($commandes as $commande)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $commande->numero }}</td>
                <td class="px-4 py-3">{{ $commande->fournisseur->nom }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">{{ $commande->statut }}</span>
                </td>
                <td class="px-4 py-3 font-bold">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Aucun achat pour cette date.</td></tr>
            @endforelse
        </tbody>
        @if($commandes->count() > 0)
        <tfoot class="bg-gray-50">
            <tr>
                <td colspan="3" class="px-4 py-3 text-right font-bold">TOTAL :</td>
                <td class="px-4 py-3 font-bold text-blue-600">{{ number_format($total, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection
