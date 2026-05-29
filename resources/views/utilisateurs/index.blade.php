@extends('layouts.app')
@section('title', 'Utilisateurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Utilisateurs</h3>
    <a href="{{ route('utilisateurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Nouvel utilisateur
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Groupe / Rôle</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                <td class="px-4 py-3">{{ $user->email }}</td>
                <td class="px-4 py-3">
                    @foreach($user->roles as $role)
                    <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700 mr-1">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td class="px-4 py-3 flex space-x-2">
                    <a href="{{ route('utilisateurs.edit', $user) }}" class="text-yellow-600 hover:underline">Modifier</a>
                    @if(auth()->id() !== $user->id)
                    <form action="{{ route('utilisateurs.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Supprimer cet utilisateur ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Aucun utilisateur.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">{{ $users->links() }}</div>
</div>
@endsection
