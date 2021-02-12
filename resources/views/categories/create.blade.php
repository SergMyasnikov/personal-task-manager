@extends('layouts.app')
@section('content')
<h3>Добавление категории</h3>
<form action="{{ route('category-store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Название</label>
        <input type="text" name="name" id="name" class="form-control" />
    </div>
    <div class="form-group">
        <label for="target_percentage">Целевое значение</label>
        <input type="text" name="target_percentage" id="target_percentage" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Добавить</button>
</form>
@endsection