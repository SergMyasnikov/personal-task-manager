@extends('layouts.app')
@section('content')
<h3>Настройки</h3>
<form action="{{ route('settings-update') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="stat-period-length">Длина периода для вычисления статистики</label>
        <input type="text" name="stat_period_length" id="stat-period-length" class="form-control" value="{{ $model->stat_period_length }}" />
    </div>
    <div class="form-group">
        <label for="stat-period-start-date">Начальная дата для вычисления статистики</label>
        <input type="date" name="stat_period_start_date" id="stat-period-start-date" class="form-control" value="<?= date("Y-m-d", is_null($model->stat_period_start_date) ? time() : strtotime($model->stat_period_start_date)) ?>" />
    </div>
    <div class="checkbox">
        <label for="is-use-start-date">
            <?php $checked = is_null($model->stat_period_start_date) ? '' : ' checked' ?>
            <input type="checkbox" name="is_use_start_date" id="is-use-start-date" class="mr-2 mb-3" {{ $checked }} />Использовать начальную дату в вычислениях
        </label>
    </div>
    <button type="submit" class="btn btn-success">Сохранить</button>
</form>
@endsection