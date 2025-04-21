<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StampController;
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
Route::get('/login', [UserController::class, 'login'])->name('login');

//ログイン画面でログインする
Route::post('/login', [UserController::class, 'startLogin']);

//管理者ログイン画面を表示する
Route::get('admin/login', [UserController::class, 'adminLogin']);

//管理者ログイン画面で、ログインする
Route::post('admin/login', [UserController::class, 'adminStartLogin']);



Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(
    function () {

        //勤怠一覧画面(管理者)を表示する
        Route::get('/attendance/list', [AttendanceController::class, 'adminShowList'])->name('attendance.list');

        //スタッフ一覧画面(管理者)を表示する
        Route::get('/staff/list', [AttendanceController::class, 'adminShowStaff'])->name('staff.list');

        //申請一覧画面(管理者)を表示する
        Route::get('/stamp_correction_request/list', [StampController::class, 'showRequest'])->name('stamp_correction_request.list');

        //スタッフ別勤怠一覧画面(管理者)を表示する
        Route::get('/attendance/staff/{id}', [AttendanceController::class, 'showList'])->name('attendance.staff');

        //修正申請承認画面を表示する
        Route::get('/stamp_correction_request/approve/{id}', [StampController::class, 'getRequest'])->name('request_detail');

        //申請一覧画面(管理者)で、承認待ちor承認済み勤怠の表示を切り替える
        Route::get('/stamp_correction_request/list', [StampController::class, 'showAdminRequestList'])->name('request.list');
        //修正申請承認画面(管理者)で、修正申請された勤怠を承認する
        Route::post('/admin/stamp_correction_request/approve/{id}', [StampController::class, 'approveRequest'])->name('approve');
    }
);


Route::middleware('auth')->group(function () {

    //ログイン後、勤務状態を取得して出勤登録画面を表示する
    Route::get('/attendance', [AttendanceController::class, 'showEntry']);

    //出勤登録画面で、出勤時刻を記録する
    Route::post('/attendance', [AttendanceController::class, 'startWork'])->name('attendance');

    //出勤登録画面で、休憩開始時刻を記録する
    Route::post('/attendance/rest', [AttendanceController::class, 'startRest'])->name('attendance.rest');

    //出勤登録画面で、退勤時刻を記録する
    Route::post('/attendance/finishwork', [AttendanceController::class, 'finishWork'])->name('attendance.finishwork');

    //出勤登録画面で、休憩終了時刻を記録する
    Route::post('/attendance/finishrest', [AttendanceController::class, 'finishRest'])->name('attendance.finishrest');

    //勤怠一覧画面を表示する
    Route::get('/attendance/list', [AttendanceController::class, 'showList'])->name('attendance.list');

    //勤怠詳細画面を表示する
    Route::get('/attendance/{id}', [AttendanceController::class, 'showDetail'])->name('attendance.detail');

    //勤怠詳細画面で、勤務内容を修正する
    Route::post('/attendance/{id}/update', [AttendanceController::class, 'updateDetail'])->name('attendance.update');

    //申請一覧画面を表示する
    Route::get('/stamp_correction_request/list', [StampController::class, 'showRequest']);

    //申請一覧画面(一般ユーザー)で、承認待ちor承認済み勤怠の表示を切り替える

});
