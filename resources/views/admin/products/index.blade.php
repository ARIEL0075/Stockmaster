@extends('admin.layout')

@section('title', 'Produits')

@section('container')
<div class="container">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1>Produits</h1>

    <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="search" name="q" value="{{ $search }}" class="form-control"
                   placeholder="Nom, référence ou catégorie...">
        </div>

        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">Toutes les catégories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($categoryId == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Tous les états</option>
                <option value="1" @selected($status === '1')>Actif</option>
                <option value="0" @selected($status === '0')>Inactif</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            @if ($search || $categoryId || $status !== null && $status !== '')
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Réinitialiser</a>
            @endif
        </div>
    </form>

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Référence</th>
                <th>Catégorie</th>
                <th>Prix d'achat</th>
                <th>Prix de vente</th>
                <th>Stock</th>
                <th>Etat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->reference }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ number_format($product->purchase_price, 0, ',', ' ') }}</td>
                    <td>{{ number_format($product->selling_price, 0, ',', ' ') }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->is_active ? 'Actif' : 'Inactif' }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="post"
                              onsubmit="return confirm('Supprimer ce produit ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Aucun produit trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}

    <p>Total : {{ $products->total() }} produit(s)</p>

</div>
@endsection