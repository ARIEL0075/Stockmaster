@extends('admin.layout')

@section('title', 'liste des categories')

@section('container')
<div class="container">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1>Catégories</h1>

    <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex gap-2 mb-3">
        <input type="search" name="q" value="{{ $search }}" class="form-control"
               placeholder="Rechercher par nom ou description...">
        <button type="submit" class="btn btn-primary">Rechercher</button>
        @if ($search)
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Réinitialiser</a>
        @endif
    </form>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <table class="table table-light">
        <thead>
            <tr>
                <th class="p-4">Nom</th>
                <th class="p-4">Description</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td class="p-4">{{ $category->name }}</td>
                    <td class="p-4">{{ $category->description }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('admin.categories.edit', $category) }}">Modifier</a>

                        <form action="{{ route('admin.categories.destroy', $category) }}"
                              method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center p-4">Aucune catégorie trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}

    <p>Total : {{ $categories->total() }} catégorie(s)</p>

</div>
@endsection