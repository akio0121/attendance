@extends('layouts.admin_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_list.css') }}">
@endsection

@section('content')
<div class="attendance-container">
    <h2 class="attendance-title">| {{ \Carbon\Carbon::parse($date)->format('Y年n月j日') }} の勤怠</h2>

    <div class="date-navigation">
        <a class="nav-button" href="{{ route('admin.attendance.list', ['date' => $previousDate]) }}">← 前日</a>
        <span class="current-date">{{ \Carbon\Carbon::parse($date)->format('Y/m/d') }}</span>
        <a class="nav-button" href="{{ route('admin.attendance.list', ['date' => $nextDate]) }}">翌日 →</a>
    </div>

    <table class="attendance-table">
        <thead>
            <tr>
                <th>名前</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance->start_work)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance->finish_work)->format('H:i') }}</td>

                @php
                $total = $attendance->rests->sum('total_rest'); // 分を合計
                $hours = floor($total / 60);
                $minutes = str_pad($total % 60, 2, '0', STR_PAD_LEFT);
                @endphp

                <td>{{ $hours }}:{{ $minutes }}</td>

                @php
                $totalRest = $attendance->rests->sum('total_rest');
                $realWork = $attendance->total_work - $totalRest;
                $hours = floor($realWork / 60);
                $minutes = str_pad($realWork % 60, 2, '0', STR_PAD_LEFT);
                @endphp

                <td>{{ $hours }}:{{ $minutes }}</td>

                <td>
                    <a class="detail-link" href="{{ route('attendance.detail', ['id' => $attendance->id]) }}">詳細</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection