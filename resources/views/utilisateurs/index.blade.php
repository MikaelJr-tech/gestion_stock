@extends('layouts.app')
@section('title', 'Utilisateurs')

@section('content')
<div class="page-header">
    <h1 class="page-title">Utilisateurs</h1>
    <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary">+ Nouvel utilisateur</a>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Groupe / Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="flex-center gap-8">
                            <div style="width:30px;height:30px;border-radius:7px;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;color:white;font-size:12px;font-weight:700;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-600 text-900">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-500">{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge badge-accent">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="actions-cell">
                        <a href="{{ route('utilisateurs.edit', $user) }}" class="btn btn-warning btn-sm">Modifier</a>
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('utilisateurs.destroy', $user) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-state-icon">👤</div>
                            <div class="empty-state-text">Aucun utilisateur.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 8px 16px;">{{ $users->links() }}</div>
</div>
@endsection
