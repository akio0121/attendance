<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;


class StampController extends Controller
{
    //申請一覧画面を表示する
    public function showRequest()
    {
        $user = Auth::user();
        $attendances = Attendance::with(['workRequest', 'user'])
            ->whereHas('workRequest')  // workRequest が存在するものだけ取得
            ->where('user_id', $user->id)
            ->get();
        return view('stamp.show_request', compact('attendances'));
    }
}
