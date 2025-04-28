@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

<div class="admin-request">
    <h2 class="admin-request__title">| 勤怠詳細</h2>

    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
        @csrf
        <div class="admin-request__table-wrap">
            <div class="admin-request__table">
                {{-- 名前 --}}
                <div class="admin-request__section admin-request__row">
                    <label class="admin-request__label">名前</label>
                    <p class="admin-request__text">{{ $attendance->user->name }}</p>
                </div>
                <hr class="admin-request__divider">
                {{-- 日付 --}}
                <div class="admin-request__section admin-request__row">
                    <label class="admin-request__label">日付</label>
                    <p class="admin-request__text">{{ \Carbon\Carbon::parse($attendance->date)->format('Y年n月j日') }}</p>
                </div>
                <hr class="admin-request__divider">

                {{-- 出勤・退勤 --}}
                <div class="admin-request__section admin-request__row">
                    <label class="admin-request__label">出勤・退勤</label>
                    <div class=" admin-request__inputs">
                        <input type="time" name="start_work" value="{{ old('start_work', $attendance->start_work) }}">

                        <div class="form__error">
                            @error('start_work')
                            {{ $message }}
                            @enderror
                        </div>
                        <span class="admin-request__tilde">～</span>
                        <input type="time" name="finish_work" value="{{ old('finish_work', $attendance->finish_work) }}">
                        <div class="form__error">
                            @error('finish_work')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="admin-request__divider">
                {{-- 休憩 --}}
                <div class="admin-request__section--vertical">
                    @foreach ($attendance->rests as $index => $rest)

                    <div class="admin-request__section admin-request__row">
                        <label class="admin-request__label">休憩{{ $loop->iteration > 1 ? $loop->iteration : '' }}</label>
                        <div class="admin-request__inputs">
                            {{-- 休憩IDをhiddenで送信 --}}
                            <input type="hidden" name="rests[{{ $index }}][id]" value="{{ $rest->id }}">

                            {{-- 開始時間 --}}
                            <input type="time" name="rests[{{ $index }}][start_rest]" value="{{ old("rests.$index.start_rest", $rest->start_rest) }}">
                            <div class="form__error">
                                @error("rests.$index.start_rest")
                                {{ $message }}
                                @enderror
                            </div> ～

                            {{-- 終了時間 --}}
                            <input type="time" name="rests[{{ $index }}][finish_rest]" value="{{ old("rests.$index.finish_rest", $rest->finish_rest) }}">
                            <div class="form__error">
                                @error("rests.$index.finish_rest")
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <hr class="admin-request__divider">
                {{-- 追加休憩 --}}
                @php
                $nextNumber = $attendance->rests->count() + 1;
                @endphp

                <div class="admin-request__section--vertical">
                    <div class="admin-request__section">
                        <label class="admin-request__label">休憩{{ $nextNumber }}</label>
                        <div class="admin-request__inputs">
                            <input type="time" name="rests[new][start_rest]" value="{{ old('rests.new.start_rest') }}">
                            <div class="form__error">
                                @error("rests.new.start_rest")
                                {{ $message }}
                                @enderror
                            </div>
                            <span class="admin-request__tilde">～</span>
                            <input type="time" name="rests[new][finish_rest]" value="{{ old('rests.new.finish_rest') }}">

                            <div class="form__error">
                                @error("rests.new.finish_rest")
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="admin-request__divider">
                {{-- 備考 --}}
                <div class="admin-request__section admin-request__row">
                    <label class="admin-request__label">備考</label>
                    <textarea name="notes" class="admin-request__textarea">{{ old('notes') }}</textarea>
                </div>
                <div class="form__error">
                    @error('notes')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="admin-request__button-wrap">
            <button type="submit" class="btn btn-primary">修正</button>
        </div>
    </form>
</div>
@endsection