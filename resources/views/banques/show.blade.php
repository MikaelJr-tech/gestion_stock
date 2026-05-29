@extends('layouts.app')
@section('title', $banque->nom)

@section('content')
<div class="mb-4">
    <a href="{{ route('banques.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux banques</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🏦 {{ $banque->nom }}</h3>
        <div class="space-y-2 text-sm">
            <div><span class="text-gray-500">N° Compte :</span> <span class="font-mono">{{ $banque->numero_compte ?? '-' }}</span></div>
            <div><span class="text-gray-500">Solde actuel :</span>
                <span class="text-xl font-bold text-green-600">
                    {{ number_format($banque->solde, 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>
        <div class="mt-4 flex space-x-2">
            <a href="{{ route('banques.edit', $banque) }}" class="px-3 py-2 text-sm bg-yellow-500 text-white rounded-lg">Modifier</a>
            <a href="{{ route('versements.create') }}" class="px-3 py-2 text-sm bg-green-600 text-white rounded-lg">+ Versement</a>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Historique des versements</h4>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left">Date</th>
                    <th class="px-3 py-2 text-left">Référence</th>
                    <th class="px-3 py-2 text-left">Montant</th>
                    <th class="px-3 py-2 text-left">Notes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($versements as $versement)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $versement->date_versement->format('d/m/Y') }}</td>
                    <td class="px-3 py-2 font-mono text-xs">{{ $versement->reference ?? '-' }}</td>
                    <td class="px-3 py-2 font-bold text-green-600">{{ number_format($versement->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="px-3 py-2 text-gray-500">{{ $versement->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-3 py-4 text-center text-gray-400">Aucun versement.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $versements->links() }}</div>
    </div>
</div>
@endsection