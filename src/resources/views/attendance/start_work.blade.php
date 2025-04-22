@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/start_work.css') }}">
@endsection

@section('content')
<div class="work-page">
    <p class="work-page__title">出勤中</p>

    <p class="work-page__ymd">
        {{ \Carbon\Carbon::now()->isoFormat('YYYY年M月D日（ddd）') }}<br>
        <span class="work-page__time">
            {{ \Carbon\Carbon::now()->isoFormat('H:mm') }}
        </span>
    </p>
    <div class="work-page__button-group">
        <form class="work-page__form" action="{{ route('attendance.finishwork') }}" method="POST">
            @csrf
            <button class="work-page__button" type="submit">退勤</button>
        </form>

        <form class="rest-page__form" action="{{ route('attendance.rest') }}" method="POST">
            @csrf
            <button class="rest-page__button" type="submit">休憩入</button>
        </form>
    </div>
</div>
    @endsection