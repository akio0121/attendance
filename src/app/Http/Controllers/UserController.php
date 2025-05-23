<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    //会員登録画面を表示する
    public function register()
    {
        return view('auth.register');
    }

    //会員登録画面で名前、メールアドレス等を登録する
    public function store(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->admin_flg = 0;
        $user->save();

        Auth::login($user);
        event(new Registered($user));
        return redirect('/email/verify');
    }

    //ログイン画面を表示する
    public function login()
    {
        return view('auth.login');
    }

    public function startLogin(LoginRequest $request)
    {
        // 認証を試みる
        if (Auth::attempt($request->only('email', 'password'), false)) {
            $user = Auth::user(); // ログインしたユーザー情報を取得

            // メール認証されていない場合
            if (is_null($user->email_verified_at)) {
                return redirect()->route('verification.notice');
            }

            // メール認証されている場合、管理者か一般ユーザーかでリダイレクト先を決定
            if ($user->admin_flg == 0) {
                return redirect('/attendance'); // 一般ユーザー用ページ
            } else {
                return redirect('/admin/attendance/list'); // 管理者用ページ
            }
        }

        // 認証失敗時のエラーメッセージ
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ]);
    }


    //管理者ログイン画面を表示する
    public function adminLogin()
    {
        Auth::guard('web')->logout();
        return view('auth.admin_login');
    }

    //管理者ログイン画面で、ログインする
    public function adminStartLogin(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'), false)) {
            $user = Auth::user();
            if ($user->admin_flg == 0) {
                return redirect('/attendance');
            } else {
                return redirect('/admin/attendance/list');
            }
        }
    }
}
