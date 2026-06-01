@extends('layouts.app')
@section('title', 'Modifier groupe')

@section('content')
<a href="{{ route('groupes.index') }}" class="back-link">← Retour aux groupes</a>

<div style="max-width: 640px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $groupe->name }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('groupes.update', $groupe) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group mb-20">
                    <label class="form-label">Nom du groupe</label>
                    <input type="text" name="name" value="{{ old('name', $groupe->name) }}" class="form-input">
                </div>

                <div class="form-section">
                    <span>Permissions</span>
                </div>

                @foreach($permissions as $module => $perms)
                <div class="mb-16">
                    <p class="fw-600 text-700 mb-8" style="font-size:12px;text-transform:uppercase;letter-spacing:.05em;">
                        {{ $module }}
                    </p>
                    <div class="grid-2">
                        @foreach($perms as $perm)
                        <label class="flex-center gap-8" style="font-size:13px;cursor:pointer;padding:4px 0;">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                   {{ $groupe->hasPermissionTo($perm->name) ? 'checked' : '' }}
                                   style="width:14px;height:14px;accent-color:var(--accent);">
                            <span class="text-700">{{ $perm->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 16px;">
                    <a href="{{ route('groupes.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection