<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理システム</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <img class="logo" src="{{ asset('storage/images/logo.svg') }}" alt="Logo">
                <nav>
                    <ul class="header-nav">
                        {{--@if (Auth::check())--}}
                        @if (Auth::check() && Auth::user()->hasVerifiedEmail())
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/attendance">勤怠</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/attendance/list">勤怠一覧</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/stamp_correction_request/list">申請</a>
                        </li>
                        <li class="header-nav__item">
                            <form class="form" action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>