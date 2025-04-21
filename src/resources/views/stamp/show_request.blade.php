@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')

<h2>申請一覧</h2>
<div class="btn-group" role="group" aria-label="Button group">
    <a href="{{ route('user.request.list', ['status' => 'waiting']) }}" class="btn btn-primary {{ $status === 'waiting' ? 'active' : '' }}">
        承認待ち
    </a>
    <a href="{{ route('user.request.list', ['status' => 'approved']) }}" class="btn btn-success {{ $status === 'approved' ? 'active' : '' }}">
        承認済み
    </a>
</div>
<table>
    <tr>
        <th>状態</th>
        <th>名前</th>
        <th>対象日時</th>
        <th>申請理由</th>
        <th>申請日時</th>
        <th>詳細</th>
    </tr>

    @foreach ($attendances as $attendance)
    <tr>
        <td>
            @if($attendance->workRequest->request_flg == 0)
            承認待ち
            @elseif ($attendance->workRequest->request_flg == 1)
            承認済み
            @endif
        </td>
        <td>{{ $attendance->user->name }}</td>
        <td>{{ $attendance->date }}</td>
        <td>{{ $attendance->requestAttendance->notes }}</td>
        <td>{{ $attendance->workRequest->request_date }}</td>
        <td>
            <a href="{{ route('attendance.detail', ['id' => $attendance->id]) }}">詳細</a>
        </td>

    </tr>
    @endforeach
</table>

@endsection