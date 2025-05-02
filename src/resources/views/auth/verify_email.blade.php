@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify_email.css') }}">
@endsection

@section('content')
<div class="verification-container">
    <div class="verification-message">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </div>

    <div class="mt-4">
        <a href="http://localhost:8025" target="_blank" class="mailhog-button">
            認証はこちらから
        </a>
    </div>

    <div class="mt-4">
        <a href="{{ route('verification.send') }}">
            認証メールを再送する
        </a>
    </div>
</div>
@endsection