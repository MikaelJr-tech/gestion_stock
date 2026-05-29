@extends('layouts.app')
@section('title', 'Nouveau groupe')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Créer un groupe d'utilisateurs</h3>

    <form action="{{ route('groupes.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom du groupe <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}"
                   placeholder="Ex: Administrateur, Caissier, Gestionnaire..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
            @foreach($permissions as $module => $perms)
            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-600 mb-2 uppercase tracking-wide">{{ $module }}</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($perms as $perm)
                    <label class="flex items-center space-x-2 text-sm">
                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                               {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600">
                        <span>{{ $perm->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('groupes.index') }}" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Annuler</a>
            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
