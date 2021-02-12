@extends('layouts.app')
@section('content')
<h3>Журнал</h3>
<?php if (count($models) > 0) : ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <tr>
          <th width="10%">Дата</th>
          <th width="20%">Категория</th>
          <th width="45%">Описание</th>
          <th width="10%">Время</th>
          <th width="15%">Действия</th>
        </tr>
        <?php foreach($models as $model) : ?>
        <tr>
          <td>{{ date('d.m.Y', strtotime($model->block_date)) }}</td>
          <td>{{ $model->category->name }}</td>
          <td>{{ $model->description }}</td>
          <td>{{ $model->block_length }}</td>
          <td><a class="btn btn-success" href="{{ route('time-block-show', $model->id) }}">Подробнее</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
{{ $models->links('vendor.pagination.default') }}
<?php else : ?>
Нет записей
<?php endif; ?>
<hr>
<a href="{{ route('time-block-create') }}" class="btn btn-success">Добавить запись</a>
@endsection