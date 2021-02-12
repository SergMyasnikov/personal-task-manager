@extends('layouts.app')
@section('content')
<h3>Статистика за период с {{ date('d.m.Y', strtotime($dates['start'])) }} по {{ date('d.m.Y', strtotime($dates['end'])) }}</h3>
<?php if (count($rows) > 0) : ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <tr>
          <th width="50%">Категория</th>
          <th width="10%">Время</th>
          <th width="10%">Целевой показатель</th>
          <th width="10%">Фактический показатель</th>
          <th width="10%">Процент соответствия</th>
          <th width="10%">Отклонение</th>
        </tr>
        <?php foreach($rows as $row) : ?>
        <tr>
          <td>{{ $row['category_name'] }}</td>
          <td>{{ $row['category_sum'] }}</td>
          <td>{{ $row['target'] }}</td>
          <td>{{ $row['fact'] }}</td>
          <td>{{ $row['congruence'] }}</td>
          <td>{{ $row['delta'] }}</td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php else : ?>
Отсутствуют данные для формирования статистики
<?php endif; ?>
@endsection