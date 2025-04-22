@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('css/request_detail.css') }}">
@endsection

@section('content')

<h2 class="request-detail__title">| 勤怠詳細</h2>
<div class="container">
    <div class="request-detail__section">
        <label class="request-detail__label">名前</label>
        <p class="request-detail__text">{{ $attendance->user->name }}</p>
    </div>
    <div class="request-detail__section">
        <label class="request-detail__label">日付</label>
        <p class="request-detail__text">{{ \Carbon\Carbon::parse($attendance->date)->format('Y年n月j日') }}</p>
    </div>
    <div class="request-detail__section">
        <label class="request-detail__label">出勤・退勤</label>
        <p class="request-detail__text">{{ \Carbon\Carbon::parse($attendance->requestAttendance->wait_start_work)->format('H:i')  }}～{{ \Carbon\Carbon::parse($attendance->requestAttendance->wait_finish_work)->format('H:i')  }}</p>
    </div>

    @foreach ($attendance->requestAttendance->requestRests as $rest)
    <div class="request-detail__section">
        <label class="request-detail__label">休憩{{ $loop->iteration > 1 ? $loop->iteration : '' }}</label>
        <p class="request-detail__text">{{ \Carbon\Carbon::parse($rest->wait_start_rest)->format('H:i') }} ～ {{ \Carbon\Carbon::parse($rest->wait_finish_rest)->format('H:i')  }}</p>
    </div>
    @endforeach

    <div class="request-detail__section">
        <label class="request-detail__label">備考</label>
        <p class="request-detail__text">{{ $attendance->requestAttendance->notes }}</p>
    </div>
</div>
@if(Auth::user()->admin_flg == 1)
@if(session('status'))
<p class="text-success">{{ session('status') }}</p>
@elseif($attendance->workRequest && $attendance->workRequest->request_flg == 1)
<p class="text-success">承認済み</p>
@else
<form method="POST" action="{{ route('admin.approve', ['id' => $attendance->id]) }}">
    @csrf
    <button type="submit" class="btn btn-primary">承認</button>
</form>
@endif
@else
<p class="request-detail__note">*承認待ちのため修正はできません。</p>
@endif
@endsection