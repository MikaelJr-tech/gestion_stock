@extends('layouts.app')
@section('title', 'Bons de sortie')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Bons de sortie</h3>
    <a href="{{ route('ventes.bons-sortie.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouveau bon de sortie
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Numéro</th>
                <th class="px-4 py-3 text-left">Motif</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Créé par</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($bons as $bon)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs font-bold">{{ $bon->numero }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $bon->motif === 'périmé' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $bon->motif }}
                    </span>
                </td>
                <td class="px-4 py-3">{{ $bon->date_sortie->format('d/m/Y') }}</td>
                <td class="px-4 py-3">{{ $bon->user->name }}</td>
                <td class="px-4 py-3">
                    <div class="flex space-x-2">
                        <a href="{{ route('ventes.bons-sortie.show', $bon) }}" class="text-blue-600 hover:underline">Voir</a>
                        <a href="{{ route('ventes.bons-sortie.imprimer', $bon) }}" target="_blank" class="text-green-600 hover:underline">PDF</a>
                        <form action="{{ route('ventes.bons-sortie.destroy', $bon) }}" method="POST"
                              onsubmit="return confirm('Supprimer ? Le stock sera restauré.')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun bon de sortie.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $bons->links() }}</div>
</div>
@endsection
