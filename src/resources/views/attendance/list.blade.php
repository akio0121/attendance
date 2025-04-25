@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<div class="page-wrapper">
    @if(Auth::user()->admin_flg === 1 && isset($user))
    <h2 class="page-title">| {{ $user->name }}さんの勤怠</h2>
    @else
    <h2 class="page-title">| 勤怠一覧</h2>
    @endif


    <div class="date-wrapper">
        <a href="{{ route('attendance.list', ['month' => $previousMonth, 'user_id' => $user->id]) }}">← 前月</a>

        <span class="current-date">
            {{ \Carbon\Carbon::createFromFormat('Y-m', $currentMonth)->format('Y/m') }}
        </span>

        <a href="{{ route('attendance.list', ['month' => $nextMonth, 'user_id' => $user->id]) }}">翌月 →</a>
    </div>

    <div class="attendance-box">
        <table class="attendance-table">
            <tr>
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>

            @foreach($daysInMonth as $day)
            @php
            $dateStr = $day->toDateString();
            $attendance = $attendances->get($dateStr);
            @endphp
            <tr>
                <td>{{ $day->format('m/d') }}（{{ $day->locale('ja')->isoFormat('ddd') }}）</td>

                @if($attendance)
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
                @else
                <td colspan="5"></td>
                @endif
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection