@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show_entry.css') }}">
@endsection

@section('content')

<p class=title>勤務外</p>

<p class="ymd">
    {{ \Carbon\Carbon::now()->isoFormat('YYYY年M月D日（ddd）') }}<br>
    <span class="time">
        {{ \Carbon\Carbon::now()->isoFormat('H:mm') }}
    </span>
</p>
<form action="{{ route('attendance') }}" method="POST">
    @csrf
    <button type="submit">出勤</button>
</form>

@endsection