@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show_entry.css') }}">
@endsection

@section('content')

<div class="entry-page">
    <p class="entry-page__title">勤務外</p>

    <p class="entry-page__ymd">
        {{ \Carbon\Carbon::now()->isoFormat('YYYY年M月D日（ddd）') }}<br>
        <span class="entry-page__time">
            {{ \Carbon\Carbon::now()->isoFormat('H:mm') }}
        </span>
    </p>
    <form class="entry-page__form" action="{{ route('attendance') }}" method="POST">
        @csrf
        <button class="entry-page__button" type="submit">出勤</button>
    </form>
</div>

@endsection