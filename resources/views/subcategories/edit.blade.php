@extends('layouts.app')
@section('content')
<h3>Подкатегория: {{ $model->name }}</h3>
<form action="{{ route('subcategory-update', $model->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Название</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $model->name }}" />
    </div>
    <button type="submit" class="btn btn-success">Сохранить</button>
</form>
@endsection