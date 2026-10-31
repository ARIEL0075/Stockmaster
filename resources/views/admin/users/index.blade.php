@extends('admin.layout')


@section('container')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Gestion des utilisateurs</h2>
            <p class="text-muted mb-0">
                Gérez les comptes de votre application.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Ajouter un utilisateur
        </a>
    </div>

    {{-- Messages de confirmation --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Liste des utilisateurs</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr>
                                <td>{{ $user->id }}</td>

                                <td class="fw-semibold">
                                    {{ $user->name }}
                                </td>

                                <td>{{ $user->email }}</td>

                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-primary">
                                            Administrateur
                                        </span>
                                    @else
                                        <span class="badge bg-info text-dark">
                                            Gestionnaire
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-success">
                                            Actif
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Inactif
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Modifier
                                        </a>

                                        @if($user->id !== auth()->id())

                                            <form action="{{ route('admin.users.toggleStatus', $user) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="btn btn-sm {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                                    {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                                </button>
                                            </form>

                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Aucun utilisateur enregistré.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>

</div>

@endsection