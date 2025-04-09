@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')

<h2>勤怠一覧</h2>

<div>
    <a href="{{ route('attendance.list', ['month' => $previousMonth]) }}">← 前月</a>

    <span class="font-bold text-lg">
        {{ \Carbon\Carbon::createFromFormat('Y-m', $currentMonth)->format('Y年n月') }}
    </span>

    <a href="{{ route('attendance.list', ['month' => $nextMonth]) }}">翌月 →</a>
</div>
<table>
    <tr>
        <th>日付</th>
        <th>出勤</th>
        <th>退勤</th>
        <th>休憩</th>
        <th>合計</th>
        <th>詳細</th>
    </tr>

    @foreach($attendances as $attendance)
    <tr>
        <td>{{ \Carbon\Carbon::parse($attendance->date)->locale('ja')->isoformat('MM月DD日（ddd）') }}</td>
        <td>{{ \Carbon\Carbon::parse($attendance->start_work)->format('H:i') }}</td>
        <td>{{ \Carbon\Carbon::parse($attendance->finish_work)->format('H:i') }}</td>
        <td>
            @php
            $total = $attendance->total_rest_minutes;
            $hours = floor($total / 60);
            $minutes = $total % 60;
            @endphp
            {{ sprintf('%02d:%02d', $hours, $minutes) }}
        </td>
        <td>
            @php
            $total = $attendance->net_work_minutes;
            $hours = floor($total / 60);
            $minutes = $total % 60;
            @endphp
            {{ sprintf('%02d:%02d', $hours, $minutes) }}
        </td>
        <td>
            <a href="{{ route('attendance.detail', ['id' => $attendance->id]) }}">詳細</a>
        </td>

    </tr>
    @endforeach
</table>

@endsection