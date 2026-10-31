@extends('admin.layout')

@section('title', 'Mouvements de stock')

@section('container')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="fw-bold mb-1">Mouvements de stock</h1>
        <p class="text-muted mb-0">Enregistrez les entrées et sorties et consultez l'historique</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Formulaire --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Nouveau mouvement</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.stock-movements.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produit</label>
                            <select name="product_id" id="product_id"
                                    class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">-- Choisir un produit --</option>
                                @foreach ($products as $p)
                                    <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>
                                        {{ $p->name }} ({{ $p->reference }}) — stock : {{ $p->quantity }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type de mouvement</label>
                            <select name="type" id="type"
                                    class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">-- Choisir --</option>
                                <option value="entree" @selected(old('type') === 'entree')>Entrée</option>
                                <option value="sortie" @selected(old('type') === 'sortie')>Sortie</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantité</label>
                            <input type="number" name="quantity" id="quantity" min="1" step="1"
                                   value="{{ old('quantity') }}"
                                   class="form-control @error('quantity') is-invalid @enderror" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Motif <span class="text-muted">(facultatif)</span>
                            </label>
                            <textarea name="description" id="description" rows="3" maxlength="255"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Ex : réception fournisseur, vente, casse...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-1"></i> Enregistrer le mouvement
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Historique --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Historique</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Produit</th>
                                <th>Type</th>
                                <th class="text-end">Quantité</th>
                                <th>Utilisateur</th>
                                <th>Motif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movements as $movement)
                                <tr>
                                    <td class="text-nowrap">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $movement->product?->name ?? '-' }}</div>
                                        <small class="text-muted">{{ $movement->product?->reference }}</small>
                                    </td>
                                    <td>
                                        @if ($movement->type === 'entree')
                                            <span class="badge bg-success">Entrée</span>
                                        @else
                                            <span class="badge bg-danger">Sortie</span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold">
                                        {{ $movement->type === 'entree' ? '+' : '-' }}{{ $movement->quantity }}
                                    </td>
                                    <td>{{ $movement->user?->name ?? '-' }}</td>
                                    <td>{{ $movement->description ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Aucun mouvement enregistré.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($movements->hasPages())
                    <div class="card-footer bg-white">
                        {{ $movements->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection