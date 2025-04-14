@extends('layouts.admin_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_list.css') }}">
@endsection

@section('content')
<h2>{{ \Carbon\Carbon::parse($date)->format('Y年n月j日') }} の勤怠</h2>

<a href="{{ route('admin.attendance.list', ['date' => $previousDate]) }}">← 前日</a>
<a>{{ $date }}</a>
<a href="{{ route('admin.attendance.list', ['date' => $nextDate]) }}">翌日 →</a>

<table>
    <tr>
        <th>名前</th>
        <th>出勤</th>
        <th>退勤</th>
        <th>休憩</th>
        <th>合計</th>
        <th>詳細</th>
    </tr>
    @foreach($attendances as $attendance)
    <tr>
        <td>{{ $attendance->user->name }}</td>
        <td>{{ $attendance->start_work }}</td>
        <td>{{ $attendance->finish_work }}</td>

        @php
        $total = $attendance->rests->sum('total_rest'); // 分を合計
        $hours = str_pad(floor($total / 60), 2, '0', STR_PAD_LEFT);
        $minutes = str_pad($total % 60, 2, '0', STR_PAD_LEFT);
        @endphp

        <td>{{ $hours }}:{{ $minutes }}</td>

        @php
        $totalRest = $attendance->rests->sum('total_rest');
        $realWork = $attendance->total_work - $totalRest;
        $hours = str_pad(floor($realWork / 60), 2, '0', STR_PAD_LEFT);
        $minutes = str_pad($realWork % 60, 2, '0', STR_PAD_LEFT);
        @endphp

        <td>{{ $hours }}:{{ $minutes }}</td>

        <td>
            <a href="{{ route('attendance.detail', ['id' => $attendance->id]) }}">詳細</a>
        </td>
    </tr>
    @endforeach
</table>
@endsection