@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/entry03.css') }}">
@endsection

@section('content')

<p class=title>休憩中</p>

<p class="ymd">
    {{ \Carbon\Carbon::now()->isoFormat('YYYY年M月D日（ddd）') }}<br>
    <span class="time">
        {{ \Carbon\Carbon::now()->isoFormat('H:mm') }}
    </span>
</p>

<form action="{{ route('attendance.finishrest') }}" method="POST">
    @csrf
    <button type="submit">休憩戻</button>
</form>

@endsection