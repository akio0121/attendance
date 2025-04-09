<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//会員登録画面を表示する
Route::get('/register', [UserController::class, 'register']);

//会員登録画面で名前、メールアドレス等を登録する
Route::post('/register', [UserController::class, 'store']);

//ヘッダーのログアウトボタンを押して、ログアウト後、ログインページへ遷移する
Route::post('/logout', function () {
    $user = Auth::user();
    Auth::logout();
    if ($user && $user->admin_flg == 0) {
        return redirect('/login');
    } else {
        return redirect('/admin/login');
    }
});

//ログイン画面を表示する
Route::get('/login', [UserController::class, 'login']);

//ログイン画面でログインする
Route::post('/login', [UserController::class, 'startLogin']);

//管理者ログイン画面を表示する
Route::get('admin/login', [UserController::class, 'adminLogin']);

//管理者ログイン画面で、ログインする
Route::post('admin/login', [UserController::class, 'adminStartLogin']);

//ログイン後、勤務状態を取得して出勤登録画面を表示する
Route::get('/attendance', [AttendanceController::class, 'showEntry'])
    ->middleware('auth');

//出勤登録画面で、出勤時刻を記録する
Route::post('/attendance', [AttendanceController::class, 'startWork'])->name('attendance')
    ->middleware('auth');

//出勤登録画面で、休憩開始時刻を記録する
Route::post('/attendance/rest', [AttendanceController::class, 'startRest'])->name('attendance.rest')
    ->middleware('auth');

//出勤登録画面で、退勤時刻を記録する
Route::post('/attendance/finishwork', [AttendanceController::class, 'finishWork'])->name('attendance.finishwork')
    ->middleware('auth');

//出勤登録画面で、休憩終了時刻を記録する
Route::post('/attendance/finishrest', [AttendanceController::class, 'finishRest'])->name('attendance.finishrest')
    ->middleware('auth');

//勤怠一覧画面を表示する
Route::get('/attendance/list', [AttendanceController::class, 'showList'])->name('attendance.list')
    ->middleware('auth');