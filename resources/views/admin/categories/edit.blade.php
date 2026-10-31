@extends('admin\layout')

@section('title', 'Modifié une categorie')

@section('container')
<div class="container">
    <h1>Modifié une categorie</h1>
</div>
<div class="container">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $category->name) }}"
                   class="form-control" placeholder="Nom de la catégorie">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description"
                      class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="container p-3">
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>
</div>
@endsection