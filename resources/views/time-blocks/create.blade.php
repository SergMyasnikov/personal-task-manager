@extends('layouts.app')
@section('content')
<h3>Добавление записи</h3>
<form action="{{ route('time-block-store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="block-date">Дата</label>
        <input type="date" name="block_date" id="block-date" class="form-control" value="<?= date("Y-m-d") ?>" />
    </div>
    <div class="form-group">
        <label for="category_id">Категория</label>
        <select class="form-control" name="category_id" id="category-id">
            <?php foreach($categories as $category) : ?>
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="description">Описание действия</label>
        <input type="text" name="description" id="description" class="form-control" />
    </div>
    <div class="form-group">
        <label for="block-length">Продолжительность</label>
        <input type="text" name="block_length" id="block-length" class="form-control" />
    </div>
    <button type="submit" class="btn btn-success">Добавить</button>
</form>
@endsection