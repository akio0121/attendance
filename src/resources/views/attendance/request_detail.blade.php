{{-- @extends('layouts.app') --}}
@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('css/request_detail.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>勤怠詳細</h2>

    <label>名前</label>
    {{--<p>{{ $user->name }}</p>--}}
    <p>{{ $attendance->user->name }}</p>
    <label>日付</label>
    <p>{{ \Carbon\Carbon::parse($attendance->date)->format('Y年n月j日') }}</p>
    <div>
        <label>出勤・退勤</label>{{ $attendance->requestAttendance->wait_start_work }}～{{ $attendance->requestAttendance->wait_finish_work }}
    </div>
    <div>
        @foreach ($attendance->requestAttendance->requestRests as $rest)
        <label>休憩{{ $loop->iteration > 1 ? $loop->iteration : '' }}</label>{{ $rest->wait_start_rest }} ～ {{ $rest->wait_finish_rest }}
        @endforeach
    </div>
    <div>
        <label>備考</label>{{ $attendance->requestAttendance->notes }}
    </div>
    @if(Auth::user()->admin_flg == 1)
    @if(session('status'))
    <p class="text-success">{{ session('status') }}</p>
    @else
    <form method="POST" action="{{ route('admin.approve', ['id' => $attendance->id]) }}">
        @csrf
        <button type="submit" class="btn btn-primary">承認</button>
    </form>
    @endif
    @else
    <p>承認待ちのため修正はできません。</p>
    @endif

</div>


@endsection