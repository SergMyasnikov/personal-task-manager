@extends('layouts.app')
@section('content')
<h3>Категория: {{ $model->name }}</h3>
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
          <td>Целевой процент</td>
          <td>{{ $model->target_percentage }}</td>
        </tr>
    </table>    
</div>
<?php if (count($model->subcategories) > 0) : ?>
<h4>Подкатегории</h4>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <tr>
          <th width="85%">Название</th>
          <th width="15%">Действия</th>
        </tr>
        <?php foreach($model->subcategories as $subcategory) : ?>
        <tr>
          <td>{{ $subcategory->name }}</td>
          <td><a class="btn btn-success" href="{{ route('subcategory-show', $subcategory->id) }}">Подробнее</a></td>
        </tr>
        <tr>
        <?php endforeach; ?>
    </table>    
</div>
<?php endif; ?>
<div class="form-inline">
<a href="{{ route('category-index') }}" class="btn btn-success" role="button">&nbsp;&nbsp;&nbsp;Назад&nbsp;&nbsp;&nbsp;</a>
<form action="{{ route('category-destroy', $model->id) }}" method="post" id="delete-form">
    @csrf
    <input type="button" value="Удалить" class="btn btn-danger ml-2" id="delete-form-button"/>
</form>
<a href="{{ route('category-edit', $model->id) }}" class="btn btn-success ml-2">Изменить</a>
<a href="{{ route('subcategory-create', $model->id) }}" class="btn btn-success ml-2">Добавить подкатегорию</a>
</div>
@endsection