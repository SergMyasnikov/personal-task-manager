@extends('layouts.app')
@section('content')
<h3>Добавление задачи</h3>
<form action="{{ route('task-store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="subcategory-id">Подкатегория</label>
        <select class="form-control" name="subcategory_id" id="subcategory-id">
            <?php foreach($category->subcategories as $subcategory) : ?>
                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="description">Описание задачи</label>
        <input type="text" name="description" id="description" class="form-control" />
    </div>
    <div class="form-group">
        <label for="priority">Приоритет</label>
        <input type="text" name="priority" id="priority" class="form-control" value="10"/>
    </div>
    <div class="form-group">
        <label for="comment">Комментарий</label>
        <textarea name="comment" id="comment" class="form-control"></textarea>
    </div>    
    <button type="submit" class="btn btn-success">Добавить</button>
</form>
@endsection