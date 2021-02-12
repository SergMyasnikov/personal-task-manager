@extends('layouts.app')
@section('content')
<h3>Категория: {{ $model->name }}</h3>
<form action="{{ route('category-update', $model->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Название</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $model->name }}" />
    </div>
    <div class="form-group">
        <label for="target_percentage">Целевое значение</label>
        <input type="text" name="target_percentage" id="target_percentage" class="form-control" value="{{ $model->target_percentage }}">
    </div>
    <button type="submit" class="btn btn-success">Сохранить</button>
</form>
@endsection