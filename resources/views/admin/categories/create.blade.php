@extends('admin\layout')

@section('title', 'Ajouter une categorie')

@section('container')
<div class="container">
    <h1>Ajouter une categorie</h1>
</div>
<div class="container">
<form action="{{route('admin.categories.store')}}" method="post">
    @csrf
   <div class="form-group">
    <label for="exampleFormControlInput1">Nom</label>
    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="informatique">
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Description</label>
    <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
 
  <div class="container p-3">
  <button type="submit" class="btn btn-primary">Ajouter</button>
  </div>
</form>
</div>
@endsection