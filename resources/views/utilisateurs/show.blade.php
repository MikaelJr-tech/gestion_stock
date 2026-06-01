@extends('layouts.app')
@section('title', $utilisateur->name)

@section('content')
<a href="{{ route('utilisateurs.index') }}" class="back-link">← Retour aux utilisateurs</a>

<div style="max-width: 500px;">
    <div class="card">
        <div class="card-header">
            <div class="flex-center gap-8">
                <div style="width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;font-weight:700;">
                    {{ strtoupper(substr($utilisateur->name, 0, 1)) }}
                </div>
                <span class="card-title">{{ $utilisateur->name }}</span>
            </div>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $utilisateur->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Groupe / Rôle</span>
                <span class="detail-value">
                    @forelse($utilisateur->roles as $role)
                        <span class="badge badge-accent">{{ $role->name }}</span>
                    @empty
                        <span class="text-400">Aucun rôle</span>
                    @endforelse
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Permissions directes</span>
                <span class="detail-value">{{ $utilisateur->getDirectPermissions()->count() }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Membre depuis</span>
                <span class="detail-value">{{ $utilisateur->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            <div class="flex gap-8">
                <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="btn btn-warning btn-sm">Modifier</a>
                @if(auth()->id() !== $utilisateur->id)
                <form action="{{ route('utilisateurs.destroy', $utilisateur) }}" method="POST"
                      onsubmit="return confirm('Supprimer cet utilisateur ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection