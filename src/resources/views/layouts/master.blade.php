@php
if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
$layout = 'layouts.admin_app';
} elseif (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
$layout = 'layouts.app';
}
@endphp

@extends($layout)