@extends('layouts.app')
@section('content')
<h3>Редактирование задачи</h3>
<form action="{{ route('task-update', $model->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="subcategory-id">Подкатегория</label>
        <select class="form-control" name="subcategory_id" id="subcategory-id">
            <?php foreach($model->subcategory->category->subcategories as $subcategory) : ?>
                <?php $selected = ($subcategory->id == $model->subcategory_id) ? ' selected' : '' ?>
                <option value="{{ $subcategory->id }}"{{ $selected }}>{{ $subcategory->name }}</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="description">Описание задачи</label>
        <input type="text" name="description" id="description" class="form-control" value="{{ $model->description }}"/>
    </div>
    <div class="form-group">
        <label for="priority">Приоритет</label>
        <input type="text" name="priority" id="priority" class="form-control" value="{{ $model->priority }}"/>
    </div>
    <div class="form-group">
        <label for="comment">Комментарий</label>
        <textarea name="comment" id="comment" class="form-control">{{ $model->comment }}</textarea>
    </div>    
    <button type="submit" class="btn btn-success">Сохранить</button>
</form>
@endsection