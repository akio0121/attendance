@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/finish_work.css') }}">
@endsection

@section('content')
<div class="finish-page">
    <p class="finish-page__title">退勤済</p>

    <p class="finish-page__ymd">
        {{ \Carbon\Carbon::now()->isoFormat('YYYY年M月D日（ddd）') }}<br>
        <span class="finish-page__time">
            {{ \Carbon\Carbon::now()->isoFormat('H:mm') }}
        </span>
    </p>

    <p class="finish-page__comment">お疲れさまでした。</p>


        @endsection