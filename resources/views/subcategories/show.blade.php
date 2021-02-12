@extends('layouts.app')
@section('content')
<h3>Подкатегория: {{ $model->name }}</h3>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <tr>
          <th width="50%">Параметр</th>
          <th width="50%">Значение</th>
        </tr>
        <tr>
          <td>Название</td>
          <td>{{ $model->name }}</td>
        </tr>
        <tr>
          <td>Главная категория</td>
          <td><?= ($model->is_default == 1) ? 'Да' : 'Нет' ?></td>
        </tr>
    </table>    
</div>
<div class="form-inline">
<a href="{{ route('category-show', $model->category_id) }}" class="btn btn-success" role="button">&nbsp;&nbsp;&nbsp;Назад&nbsp;&nbsp;&nbsp;</a>
<form action="{{ route('subcategory-destroy', $model->id) }}" method="post" id="delete-form">
    @csrf
    <input type="button" value="Удалить" class="btn btn-danger ml-2" id="delete-form-button"/>
</form>
<a href="{{ route('subcategory-edit', $model->id) }}" class="btn btn-success ml-2">Изменить</a>
</div>
@endsection