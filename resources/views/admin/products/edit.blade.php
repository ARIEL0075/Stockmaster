@extends('admin.layout')

@section('title', 'Modifier un produit')

@section('container')
<div class="container mt-4">
    <h1>Modifier un produit</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name) }}" placeholder="Eren">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="reference" class="form-label">Référence</label>
                <input type="text" name="reference" id="reference"
                       class="form-control @error('reference') is-invalid @enderror"
                       value="{{ old('reference', $product->reference) }}" placeholder="CLV-444">
                @error('reference')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Catégorie</label>
                <select name="category_id" id="category_id"
                        class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="purchase_price" class="form-label">Prix d'achat</label>
                <input type="number" name="purchase_price" id="purchase_price"
                       class="form-control @error('purchase_price') is-invalid @enderror"
                       value="{{ old('purchase_price', $product->purchase_price) }}" placeholder="23000">
                @error('purchase_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="selling_price" class="form-label">Prix de vente</label>
                <input type="number" name="selling_price" id="selling_price"
                       class="form-control @error('selling_price') is-invalid @enderror"
                       value="{{ old('selling_price', $product->selling_price) }}" placeholder="40000">
                @error('selling_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="quantity" class="form-label">Qté initiale</label>
                <input type="number" name="quantity" id="quantity"
                       class="form-control @error('quantity') is-invalid @enderror"
                       value="{{ old('quantity', $product->quantity) }}" placeholder="20">
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="min_stock" class="form-label">Seuil minimum</label>
            <input type="number" name="min_stock" id="min_stock"
                   class="form-control @error('min_stock') is-invalid @enderror"
                   value="{{ old('min_stock', $product->min_stock) }}" placeholder="3">
            @error('min_stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-check form-switch my-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active" value="1"
           class="form-check-input"
           {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Actif</label>
</div>

        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection