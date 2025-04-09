@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/finish_work.css') }}">
@endsection

@section('content')

<p class=title>退勤済</p>

<p class="ymd">
    {{ \Carbon\Carbon::now()->isoFormat('YYYY年M月D日（ddd）') }}<br>
    <span class="time">
        {{ \Carbon\Carbon::now()->isoFormat('H:mm') }}
    </span>
</p>

<p>お疲れさまでした。</p>


@endsection