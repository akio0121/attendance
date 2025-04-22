@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/start_rest.css') }}">
@endsection

@section('content')
<div class="rest-page">
    <p class="rest-page__title">休憩中</p>

    <p class="rest-page__ymd">
        {{ \Carbon\Carbon::now()->isoFormat('YYYY年M月D日（ddd）') }}<br>
        <span class="rest-page__time">
            {{ \Carbon\Carbon::now()->isoFormat('H:mm') }}
        </span>
    </p>

    <form class="rest-page__form" action="{{ route('attendance.finishrest') }}" method="POST">
        @csrf
        <button class="rest-page__button" type="submit">休憩戻</button>
    </form>

    @endsection