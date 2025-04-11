@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>勤怠詳細</h2>

    <label>名前</label>
    <p>{{ $user->name }}</p>
    <label>日付</label>
    <p>{{ \Carbon\Carbon::parse($attendance->date)->format('Y年n月j日') }}</p>

    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
        @csrf
        <div>
            <label>出勤・退勤</label>
            <input type="time" name="start_work" value="{{ old('start_work', $attendance->start_work) }}" required>～
            <input type="time" name="finish_work" value="{{ old('finish_work', $attendance->finish_work) }}" required>
        </div>
        <div>
            @foreach ($attendance->rests as $rest)
            休憩{{ $loop->iteration > 1 ? $loop->iteration : '' }}
            <input type="time" name="start_rest" value="{{ old('start_rest', $rest->start_rest) }}" required>～
            <input type="time" name="finish_rest" value="{{ old('finish_rest', $rest->finish_rest) }}" required>
            @endforeach
        </div>

        @php
        $nextNumber = $attendance->rests->count() + 1;
        @endphp

        <div>
            <label>休憩{{ $nextNumber }}</label>
            <input type="time" name="rests[new][start_rest]" value="{{ old('rests.new.start_rest') }}">～
            <input type="time" name="rests[new][finish_rest]" value="{{ old('rests.new.finish_rest') }}">
        </div>
    </form>
</div>
@endsection