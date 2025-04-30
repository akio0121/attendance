@extends('layouts.admin_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_request.css') }}">
@endsection

@section('content')
<div class="admin-request">
    <h2 class="admin-request__title">| 申請一覧</h2>

    <div class="admin-request__tabs">
        <a href="{{ route('admin.request.list', ['status' => 'waiting']) }}" class="btn btn-primary {{ ($status ?? 'waiting') === 'waiting' ? 'active' : '' }}">承認待ち</a>
        <a href="{{ route('admin.request.list', ['status' => 'approved']) }}" class="btn btn-success {{ ($status ?? 'waiting') === 'approved' ? 'active' : '' }}">承認済み</a>
    </div>

    <hr class="admin-request__divider">

    <div class="admin-request__table-wrap">
        <table class="admin-request__table">
            <thead>
                <tr>
                    <th>状態</th>
                    <th>名前</th>
                    <th>対象日時</th>
                    <th>申請理由</th>
                    <th>申請日時</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
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
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('Y/m/d') }}</td>
                    <td>{{ $attendance->requestAttendance->notes}}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->workRequest->request_date)->format('Y/m/d') }}</td>
                    <td>
                        <a href="{{ route('request_detail', ['id' => $attendance->id]) }}">詳細</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection