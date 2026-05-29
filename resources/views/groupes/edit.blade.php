@extends('layouts.app')
@section('title', 'Modifier groupe')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Modifier : {{ $groupe->name }}</h3>

    <form action="{{ route('groupes.update', $groupe) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom du groupe</label>
            <input type="text" name="name" value="{{ old('name', $groupe->name) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
            @foreach($permissions as $module => $perms)
            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-600 mb-2 uppercase">{{ $module }}</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($perms as $perm)
                    <label class="flex items-center space-x-2 text-sm">
                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                               {{ $groupe->hasPermissionTo($perm->name) ? 'checked' : '' }}
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
            <button type="submit" class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
