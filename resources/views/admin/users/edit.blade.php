@extends('admin.layout')

@section('container')

<div class="container-fluid">

    {{-- En-tête --}}
    <div class="mb-4">
        <h2 class="fw-bold">Modifier un utilisateur</h2>
        <p class="text-muted mb-0">
            Modifiez les informations du compte.
        </p>
    </div>

    {{-- Erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Informations de l'utilisateur</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.users.update', $user) }}" method="POST">

                @csrf
                @method('PUT')

                {{-- Nom --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nom complet</label>

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>

                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}"
                           required>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Rôle --}}
                <div class="mb-3">
                    <label for="role" class="form-label">Rôle</label>

                    <select name="role"
                            id="role"
                            class="form-select @error('role') is-invalid @enderror"
                            required>

                        <option value="admin"
                            {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                            Administrateur
                        </option>

                        <option value="gestionnaire"
                            {{ old('role', $user->role) == 'gestionnaire' ? 'selected' : '' }}>
                            Gestionnaire
                        </option>

                    </select>

                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <h6 class="fw-bold mb-3">Modifier le mot de passe</h6>

                <p class="text-muted small">
                    Laissez ces champs vides si vous ne souhaitez pas modifier le mot de passe.
                </p>

                {{-- Nouveau mot de passe --}}
                <div class="mb-3">
                    <label for="password" class="form-label">
                        Nouveau mot de passe
                    </label>

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimum 8 caractères">

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmation --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">
                        Confirmer le nouveau mot de passe
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control"
                           placeholder="Répétez le nouveau mot de passe">
                </div>

                {{-- Boutons --}}
                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-outline-secondary">
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection