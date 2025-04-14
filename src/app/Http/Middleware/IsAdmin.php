<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // ログインしていない場合はログインページへ
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 管理者でない場合もログインページへ
        if (auth()->user()->admin_flg != 1) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
