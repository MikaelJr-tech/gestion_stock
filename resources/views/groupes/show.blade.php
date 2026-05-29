@extends('layouts.app')
@section('title', $groupe->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('groupes.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux groupes</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🔐 {{ $groupe->name }}</h3>
        <div class="space-y-2 text-sm">
            <div><span class="text-gray-500">Permissions :</span>
                <span class="font-bold text-blue-600">{{ $groupe->permissions->count() }}</span>
            </div>
            <div><span class="text-gray-500">Utilisateurs dans ce groupe :</span>
                <span class="font-bold">{{ $groupe->users->count() }}</span>
            </div>
        </div>
        <a href="{{ route('groupes.edit', $groupe) }}"
           class="mt-4 inline-block px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg">Modifier</a>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold text-gray-700 mb-4">Permissions accordées</h4>
        @php $grouped = $groupe->permissions->groupBy(fn($p) => explode('.', $p->name)[0]); @endphp
        @forelse($grouped as $module => $perms)
        <div class="mb-4">
            <p class="text-sm font-semibold text-gray-600 uppercase mb-2">{{ $module }}</p>
            <div class="flex flex-wrap gap-2">
                @foreach($perms as $perm)
                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs">{{ $perm->name }}</span>
                @endforeach
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-400">Aucune permission accordée.</p>
        @endforelse
    </div>
</div>
@endsection
