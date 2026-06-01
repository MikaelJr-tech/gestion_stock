@extends('layouts.app')
@section('title', 'Nouvel utilisateur')

@section('content')
<a href="{{ route('utilisateurs.index') }}" class="back-link">← Retour aux utilisateurs</a>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <span class="card-title">Créer un utilisateur</span>
        </div>
        <div class="card-body">
            <form action="{{ route('utilisateurs.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nom <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input">
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span class="req">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input">
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Mot de passe <span class="req">*</span></label>
                        <input type="password" name="password" class="form-input">
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirmer mot de passe <span class="req">*</span></label>
                        <input type="password" name="password_confirmation" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Groupe / Rôle <span class="req">*</span></label>
                    <select name="role" class="form-select">
                        <option value="">— Choisir un groupe —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-8" style="justify-content: flex-end; margin-top: 8px;">
                    <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection