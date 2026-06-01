@extends('layouts.app')
@section('title', $groupe->name)

@section('content')
<a href="{{ route('groupes.index') }}" class="back-link">← Retour aux groupes</a>

<div class="grid-2 mb-20" style="align-items: start;">

    <div class="card">
        <div class="card-header">
            <span class="card-title">🔐 {{ $groupe->name }}</span>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Permissions accordées</span>
                <span class="detail-value fw-600 text-accent">{{ $groupe->permissions->count() }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Utilisateurs dans ce groupe</span>
                <span class="detail-value fw-600">{{ $groupe->users->count() }}</span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            <a href="{{ route('groupes.edit', $groupe) }}" class="btn btn-warning btn-sm">Modifier</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Permissions accordées</span>
        </div>
        <div class="card-body">
            @php $grouped = $groupe->permissions->groupBy(fn($p) => explode('.', $p->name)[0]); @endphp
            @forelse($grouped as $module => $perms)
            <div class="mb-12">
                <p class="fw-600 text-400 mb-8" style="font-size:10.5px;text-transform:uppercase;letter-spacing:.06em;">
                    {{ $module }}
                </p>
                <div class="flex flex-wrap gap-4">
                    @foreach($perms as $perm)
                        <span class="badge badge-accent" style="font-size:10.5px;">{{ $perm->name }}</span>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">🔐</div>
                <div class="empty-state-text">Aucune permission accordée.</div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection