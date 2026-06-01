@extends('layouts.app')
@section('title', 'Modifier utilisateur')

@section('content')
<a href="{{ route('utilisateurs.index') }}" class="back-link">← Retour aux utilisateurs</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Modifier : {{ $utilisateur->name }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('utilisateurs.update', $utilisateur) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" name="name" value="{{ old('name', $utilisateur->name) }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $utilisateur->email) }}" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Nouveau mot de passe
                        <span class="text-400" style="font-size:11px;">(laisser vide pour ne pas changer)</span>
                    </label>
                    <input type="password" name="password" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Groupe / Rôle</label>
                    <select name="role" class="form-select">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ $utilisateur->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection