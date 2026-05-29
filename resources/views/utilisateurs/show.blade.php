@extends('layouts.app')
@section('title', $utilisateur->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('utilisateurs.index') }}" class="text-sm text-blue-600 hover:underline">← Retour aux utilisateurs</a>
</div>

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-6">👤 {{ $utilisateur->name }}</h3>

    <div class="space-y-4 text-sm">
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-500">Email</span>
            <span class="font-medium">{{ $utilisateur->email }}</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-500">Groupe / Rôle</span>
            <div class="flex flex-wrap gap-1 justify-end">
                @forelse($utilisateur->roles as $role)
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">{{ $role->name }}</span>
                @empty
                    <span class="text-gray-400">Aucun rôle</span>
                @endforelse
            </div>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-500">Permissions directes</span>
            <span class="font-medium">{{ $utilisateur->getDirectPermissions()->count() }}</span>
        </div>
        <div class="flex justify-between pb-3">
            <span class="text-gray-500">Membre depuis</span>
            <span class="font-medium">{{ $utilisateur->created_at->format('d/m/Y') }}</span>
        </div>
    </div>

    <div class="flex space-x-3 mt-6">
        <a href="{{ route('utilisateurs.edit', $utilisateur) }}"
           class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
            Modifier
        </a>
        @if(auth()->id() !== $utilisateur->id)
        <form action="{{ route('utilisateurs.destroy', $utilisateur) }}" method="POST"
              onsubmit="return confirm('Supprimer cet utilisateur ?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
                Supprimer
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
