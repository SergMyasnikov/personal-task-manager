@extends('layouts.app')
@section('content')
<h3>Просмотр записи журнала</h3>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <tr>
          <th width="50%">Параметр</th>
          <th width="50%">Значение</th>
        </tr>
        <tr>
          <td>Дата</td>
          <td>{{ date('d.m.Y', strtotime($model->block_date)) }}</td>
        </tr>
        <tr>
          <td>Категория</td>
          <td>{{ $model->category->name }}</td>
        </tr>
        <tr>
          <td>Описание</td>
          <td>{{ $model->description }}</td>
        </tr>
        <tr>
          <td>Продолжительность</td>
          <td>{{ $model->block_length }}</td>
        </tr>
    </table>    
</div>
<div class="form-inline">
<a href="{{ route('time-block-index') }}" class="btn btn-success" role="button">&nbsp;&nbsp;&nbsp;Назад&nbsp;&nbsp;&nbsp;</a>
<form action="{{ route('time-block-destroy', $model->id) }}" method="post" id="delete-form">
    @csrf
    <input type="button" value="Удалить" class="btn btn-danger ml-2"  id="delete-form-button"/>
</form>
<a href="{{ route('time-block-edit', $model->id) }}" class="btn btn-success ml-2">Изменить</a>
</div>
@endsection