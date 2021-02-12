@extends('layouts.app')
@section('content')
<h3>Задачи</h3>
<?php if (count($models) > 0) : ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <tr>
          <th width="25%">Категория</th>
          <th width="25%">Подкатегория</th>
          <th width="35%">Описание</th>
          <th width="15%">Действия</th>
        </tr>
        <?php foreach($models as $model) : ?>
        <tr>
          <td>{{ $model->subcategory->category->name }}</td>
          <td>{{ $model->subcategory->name }}</td>
          <td>{{ $model->description }}</td>
          <td><a class="btn btn-success" href="{{ route('task-show', $model->id) }}">Подробнее</a></td>
        </tr>
        <?php endforeach; ?>
    </table>    
</div>
{{ $models->links('vendor.pagination.default') }}
<?php else : ?>
Список пуст
<?php endif; ?>
<hr>
<?php if (count($categories) > 0) : ?>
<form class="form-inline" action="{{ route('task-create') }}" method="get">
    @csrf
    <select class="form-control" name="category_id" id="category-id">
        <?php foreach($categories as $category) : ?>
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        <?php endforeach; ?>
    </select>
    <input type="submit" class="btn btn-success ml-2" value="Добавить задачу">
</form>
<?php else : ?>
Для добавления заданий нужно предварительно добавить категории
<?php endif; ?>
@endsection