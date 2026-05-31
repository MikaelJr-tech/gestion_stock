@extends('layouts.app')
@section('title', 'Groupes & Droits')

@section('content')
<div class="page-header">
    <h1 class="page-title">Groupes & Droits</h1>
    <a href="{{ route('groupes.create') }}" class="btn btn-primary">+ Nouveau groupe</a>
</div>

<div class="grid-3">
    @forelse($groupes as $groupe)
    <div class="card">
        <div class="card-header">
            <span class="card-title">🔐 {{ $groupe->name }}</span>
            <div class="flex gap-4">
                <a href="{{ route('groupes.edit', $groupe) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('groupes.destroy', $groupe) }}" method="POST" style="display:inline;"
                      onsubmit="return confirm('Supprimer ce groupe ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Suppr.</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <p class="text-400 mb-12" style="font-size:12px;">
                {{ $groupe->permissions->count() }} permission(s)
            </p>
            <div class="flex flex-wrap gap-4">
                @foreach($groupe->permissions->take(6) as $perm)
                    <span class="badge badge-accent" style="font-size:10px;">{{ $perm->name }}</span>
                @endforeach
                @if($groupe->permissions->count() > 6)
                    <span class="badge badge-neutral" style="font-size:10px;">
                        +{{ $groupe->permissions->count() - 6 }} autres
                    </span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: span 3;">
        <div class="empty-state">
            <div class="empty-state-icon">🔐</div>
            <div class="empty-state-text">Aucun groupe créé.</div>
        </div>
    </div>
    @endforelse
</div>
@endsection
