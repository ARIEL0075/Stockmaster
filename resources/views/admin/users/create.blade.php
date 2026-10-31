@extends('admin.layout')


@section('container')

<div class="container-fluid">

    {{-- En-tête --}}
    <div class="mb-4">
        <h2 class="fw-bold">Ajouter un utilisateur</h2>
        <p class="text-muted mb-0">
            Créez un nouveau compte utilisateur.
        </p>
    </div>

    {{-- Affichage des erreurs --}}
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

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                {{-- Nom --}}
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Nom complet
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Ex : Ariel Houeto"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">
                        Adresse e-mail
                    </label>

                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="exemple@gmail.com"
                           required>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="mb-3">
                    <label for="password" class="form-label">
                        Mot de passe
                    </label>

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimum 8 caractères"
                           required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmation --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        Confirmer le mot de passe
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control"
                           placeholder="Répétez le mot de passe"
                           required>
                </div>

                {{-- Rôle --}}
                <div class="mb-4">
                    <label for="role" class="form-label">
                        Rôle de l'utilisateur
                    </label>

                    <select name="role"
                            id="role"
                            class="form-select @error('role') is-invalid @enderror"
                            required>

                        <option value="">Choisir un rôle</option>

                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                            Administrateur
                        </option>

                        <option value="gestionnaire" {{ old('role') == 'gestionnaire' ? 'selected' : '' }}>
                            Gestionnaire
                        </option>

                    </select>

                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Boutons --}}
                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-outline-secondary">
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i>
                        Créer l'utilisateur
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection