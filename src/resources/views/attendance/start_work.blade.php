@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/start_work.css') }}">
@endsection

@section('content')

<p class=title>出勤中</p>

<p class="ymd">
    {{ \Carbon\Carbon::now()->isoFormat('YYYY年M月D日（ddd）') }}<br>
    <span class="time">
        {{ \Carbon\Carbon::now()->isoFormat('H:mm') }}
    </span>
</p>

<form action="{{ route('attendance.finishwork') }}" method="POST">
    @csrf
    <button type="submit">退勤</button>
</form>

<form action="{{ route('attendance.rest') }}" method="POST">
    @csrf
    <button type="submit">休憩入</button>
</form>


@endsection