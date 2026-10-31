@extends('admin.layout')

@section('title', 'Tableau de bord')

@section('container')
<div class="container py-4">

    <div class="mb-4">
        <h1 class="fw-bold mb-1">Tableau de bord</h1>
        <p class="text-muted mb-0">Vue d'ensemble de votre boutique</p>
    </div>

    {{-- Cartes de statistiques --}}
    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                    <div class="card-body">
                        <p class="text-muted text-uppercase small fw-semibold mb-2">Produits</p>
                        <h2 class="fw-bold text-dark mb-0">{{ $totalProducts }}</h2>
                        <small class="text-primary">Voir la liste →</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                    <div class="card-body">
                        <p class="text-muted text-uppercase small fw-semibold mb-2">Catégories</p>
                        <h2 class="fw-bold text-dark mb-0">{{ $totalCategories }}</h2>
                        <small class="text-success">Voir la liste →</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <p class="text-muted text-uppercase small fw-semibold mb-2">Stock faible</p>
                    <h2 class="fw-bold text-dark mb-0">{{ $lowStock }}</h2>
                   <small class="text-muted">Sous le seuil minimal défini pour chaque produit</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
                <div class="card-body">
                    <p class="text-muted text-uppercase small fw-semibold mb-2">Rupture de stock</p>
                    <h2 class="fw-bold text-dark mb-0">{{ $outOfStock }}</h2>
                    <small class="text-muted">Quantité égale à 0</small>
                </div>
            </div>
        </div>

    </div>

    {{-- Produits à surveiller --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="fw-bold mb-0">Produits à surveiller</h5>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">
                Tous les produits
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Référence</th>
                        <th>Catégorie</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alerts as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->name }}</td>
                            <td>{{ $item->reference }}</td>
                            <td>{{ $item->category->name ?? '-' }}</td>
                            <td class="text-center fw-bold">{{ $item->quantity }}</td>
                            <td class="text-center">
                                @if ($item->quantity <= 0)
                                    <span class="badge bg-danger">Rupture</span>
                                @else
                                    <span class="badge bg-warning text-dark">Stock faible</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $item) }}"
                                   class="btn btn-sm btn-warning">Modifier</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucun produit en stock faible 🎉
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection