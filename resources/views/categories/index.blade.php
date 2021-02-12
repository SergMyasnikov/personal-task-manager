@extends('layouts.app')
@section('content')
<h3>Категории</h3>
<?php if (count($models) > 0) : ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <tr>
          <th width="70%">Название</th>
          <th width="15%">Целевой %</th>
          <th width="15%">Действия</th>
        </tr>
        <?php foreach($models as $model) : ?>
        <tr>
          <td>{{ $model->name }}</td>
          <td>{{ $model->target_percentage }}</td>
          <td><a class="btn btn-success" href="{{ route('category-show', $model->id) }}">Подробнее</a></td>
        </tr>
        <?php endforeach; ?>
    </table>    
</div>
<?php else : ?>
Список пуст
<?php endif; ?>
<hr>
<a href="{{ route('category-create') }}" class="btn btn-success">Добавить</a>
@endsection