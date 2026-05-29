@extends('layouts.app')
@section('title', 'État des versements banque')

@section('content')
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form method="GET" class="flex items-end space-x-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Du</label>
            <input type="date" name="debut" value="{{ $debut }}"
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Au</label>
            <input type="date" name="fin" value="{{ $fin }}"
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">🔍 Filtrer</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between">
        <h3 class="font-semibold text-gray-700">Versements du {{ \Carbon\Carbon::parse($debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($fin)->format('d/m/Y') }}</h3>
        <span class="text-lg font-bold text-green-600">Total : {{ number_format($total, 0, ',', ' ') }} FCFA</span>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Banque</th>
                <th class="px-4 py-3 text-left">Référence</th>
                <th class="px-4 py-3 text-left">Montant</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($versements as $versement)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $versement->date_versement->format('d/m/Y') }}</td>
                <td class="px-4 py-3 font-medium">{{ $versement->banque->nom }}</td>
                <td class="px-4 py-3 font-mono text-xs">{{ $versement->reference ?? '-' }}</td>
                <td class="px-4 py-3 font-bold text-green-600">{{ number_format($versement->montant, 0, ',', ' ') }} FCFA</td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Aucun versement pour cette période.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
