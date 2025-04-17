@extends('layouts.admin_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_request.css') }}">
@endsection

@section('content')
<h2>申請一覧</h2>

<table>
    <tr>
        <th>状態</th>
        <th>名前</th>
        <th>対象日時</th>
        <th>申請理由</th>
        <th>申請日時</th>
        <th>詳細</th>
    </tr>
    @foreach($attendances as $attendance)
    <tr>
        <td>
            @php
            $status = $attendance->workRequest->request_flg ?? null;
            @endphp

            @if ($status === 0)
            承認待ち
            @elseif ($status === 1)
            承認済み
            @endif
        </td>
        <td>{{ $attendance->user->name }}</td>
        <td>{{ $attendance->date }}</td>
        <td>{{ $attendance->requestAttendance->notes}}</td>
        <td>{{ $attendance->workRequest->request_date}}</td>
        <td>
            <a href="{{ route('admin.request_detail', ['id' => $attendance->id]) }}">詳細</a>
        </td>
    </tr>
    @endforeach
</table>




@endsection