@extends('layouts.app')
@section('content')
<h3>Просмотр задачи</h3>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <tr>
          <th width="50%">Параметр</th>
          <th width="50%">Значение</th>
        </tr>
        <tr>
          <td>Категория</td>
          <td>{{ $model->subcategory->category->name }}</td>
        </tr>
        <tr>
          <td>Подкатегория</td>
          <td>{{ $model->subcategory->name }}</td>
        </tr>
        <tr>
          <td>Описание</td>
          <td>{{ $model->description }}</td>
        </tr>
        <tr>
          <td>Приоритет</td>
          <td>{{ $model->priority }}</td>
        </tr>
        <tr>
          <td>Комментарий</td>
          <td>{{ $model->comment }}</td>
        </tr>
    </table>    
</div>
<div class="form-inline">
<a href="{{ route('task-index') }}" class="btn btn-success" role="button">&nbsp;&nbsp;&nbsp;Назад&nbsp;&nbsp;&nbsp;</a>
<form action="{{ route('task-destroy', $model->id) }}" method="post" id="delete-form">
    @csrf
    <input type="button" value="Удалить" class="btn btn-danger ml-2" id="delete-form-button"/>
</form>
<a href="{{ route('task-edit', $model->id) }}" class="btn btn-success ml-2">Изменить</a>
</div>
@endsection