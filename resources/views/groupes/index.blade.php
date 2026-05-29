@extends('layouts.app')
@section('title', 'Groupes & Droits')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Groupes d'utilisateurs</h3>
    <a href="{{ route('groupes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouveau groupe
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($groupes as $groupe)
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-start mb-4">
            <h4 class="font-bold text-gray-800 text-lg">🔐 {{ $groupe->name }}</h4>
            <div class="flex space-x-2">
                <a href="{{ route('groupes.edit', $groupe) }}" class="text-yellow-600 hover:underline text-sm">Modifier</a>
                <form action="{{ route('groupes.destroy', $groupe) }}" method="POST"
                      onsubmit="return confirm('Supprimer ce groupe ?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline text-sm">Supprimer</button>
                </form>
            </div>
        </div>
        <p class="text-sm text-gray-500 mb-3">{{ $groupe->permissions->count() }} permission(s)</p>
        <div class="flex flex-wrap gap-1">
            @foreach($groupe->permissions->take(6) as $perm)
            <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs">{{ $perm->name }}</span>
            @endforeach
            @if($groupe->permissions->count() > 6)
            <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs">+{{ $groupe->permissions->count() - 6 }} autres</span>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center text-gray-400 py-10">Aucun groupe créé.</div>
    @endforelse
</div>
@endsection
