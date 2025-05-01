@extends('layouts.app')

@section('content')
<div class="mb-4 text-sm text-gray-600">
    登録ありがとうございます！メールアドレスの確認リンクを送信しました。届いたメールをご確認ください。
</div>

@if (session('status') == 'verification-link-sent')
<div class="mb-4 font-medium text-sm text-green-600">
    新しい確認リンクをメールに送信しました。
</div>
@endif

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <div>
        <button type="submit">
            確認メールを再送信
        </button>
    </div>
</form>
@endsection