@extends('layouts.app')
@section('content')
<h3>Добавление подкатегории в категорию '{{ $category->name }}'</h3>
<form action="{{ route('subcategory-store', $category->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Название</label>
        <input type="text" name="name" id="name" class="form-control" />
    </div>
    <button type="submit" class="btn btn-success">Добавить</button>
</form>
@endsection