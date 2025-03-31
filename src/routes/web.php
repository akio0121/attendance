<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/register',[UserController::class, 'register']);

//会員登録画面で名前、メールアドレス等を登録する
Route::post('/register', [UserController::class, 'store']);
