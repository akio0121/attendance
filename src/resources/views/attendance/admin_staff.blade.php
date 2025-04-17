@extends('layouts.admin_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_staff.css') }}">
@endsection

@section('content')
<h2>スタッフ一覧</h2>

<table>
    <tr>
        <th>名前</th>
        <th>メールアドレス</th>
        <th>月次勤怠</th>
    </tr>

    @foreach($staffs as $staff)
    <tr>
        <td>{{ $staff->name }}</td>
        <td>{{ $staff->email }}</td>
        <td>
            <a href="{{ route('admin.attendance.staff', ['id' => $staff->id]) }}">詳細</a>
        </td>
    </tr>
    @endforeach
</table>
@endsection