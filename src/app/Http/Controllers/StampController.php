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

        if ($user->admin_flg === 1) {
            // ログインユーザーが管理者の場合
            $attendances = Attendance::with(['workRequest', 'user'])
                ->whereHas('workRequest')  // workRequest が存在するものだけ取得
                ->get();

            return view('stamp.admin_request', compact('attendances'));
        } else {

            //ログインユーザーが一般の場合
            $attendances = Attendance::with(['workRequest', 'user'])
                ->whereHas('workRequest')  // workRequest が存在するものだけ取得
                ->where('user_id', $user->id)
                ->get();
            return view('stamp.show_request', compact('attendances'));
        }
    }

    //修正申請承認画面を表示する
    public function approveRequest($id)
    {
        // $id に対応する Attendance レコードを取得
        $attendance = Attendance::with(['workRequest', 'user', 'requestAttendance'])->findOrFail($id);

        // 承認ページを表示
        return view('attendance.request_detail', compact('attendance'));
    }
}
