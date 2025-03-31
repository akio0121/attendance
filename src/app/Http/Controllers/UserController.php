<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    }
}
