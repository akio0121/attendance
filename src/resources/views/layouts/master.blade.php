@php
$layout = Auth::check() && Auth::user()->admin_flg == 1 ? 'layouts.admin_app' : 'layouts.app';
@endphp

@extends($layout)