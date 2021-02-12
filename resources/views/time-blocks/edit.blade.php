@extends('layouts.app')
@section('content')
<h3>Редактирование записи</h3>
<form action="{{ route('time-block-update', $model->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="block-date">Дата</label>
        <input type="date" name="block_date" id="block-date" class="form-control" value="<?= date("Y-m-d", strtotime($model->block_date)) ?>" />
    </div>
    <div class="form-group">
        <label for="category-id">Подкатегория</label>
        <select class="form-control" name="category_id" id="category-id">
            <?php foreach($categories as $category) : ?>
                <?php $selected = ($category->id == $model->category_id) ? ' selected' : '' ?>
                <option value="{{ $category->id }}"{{ $selected }}>{{ $category->name }}</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="description">Описание действия</label>
        <input type="text" name="description" id="description" class="form-control" value="{{ $model->description }}" />
    </div>
    <div class="form-group">
        <label for="block-length">Продолжительность</label>
        <input type="text" name="block_length" id="block-length" class="form-control" value="{{ $model->block_length }}" />
    </div>
    <button type="submit" class="btn btn-success">Сохранить</button>
</form>
@endsection