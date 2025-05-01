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

        /*Auth::login($user);
        return redirect('/attendance');*/
    }

    //ログイン画面を表示する
    public function login()
    {
        return view('auth.login');
    }

    //ログイン画面でログインする
    public function startLogin(LoginRequest $request)
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

    //管理者ログイン画面を表示する
    public function adminLogin()
    {
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
