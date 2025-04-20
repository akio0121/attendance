<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use App\Models\RequestAttendance;
use App\Models\Rest;
use App\Models\RequestRest;
use App\Models\WorkRequest;
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
    public function getRequest($id)
    {
        // $id に対応する Attendance レコードを取得
        $attendance = Attendance::with(['workRequest', 'user', 'requestAttendance'])->findOrFail($id);

        // 承認ページを表示
        return view('attendance.request_detail', compact('attendance'));
    }

    //修正申請承認画面(管理者)で、修正申請された勤怠を承認する
    public function approveRequest($id)
    {
        DB::transaction(function () use ($id) {
            //request_attendancesテーブルを取得
            $requestAttendance = RequestAttendance::with('requestRests')->where('attendance_id', $id)->firstOrFail();

            //attendancesテーブルの更新
            $attendance = Attendance::findOrFail($id);
            $attendance->update([
                'start_work' => $requestAttendance->wait_start_work,
                'finish_work' => $requestAttendance->wait_finish_work,
                'notes' => $requestAttendance->notes,
                //total_work再計算
            ]);

            //rests テーブルの更新（既存削除→再登録）
            Rest::where('attendance_id', $id)->delete();

            foreach ($requestAttendance->requestRests as $requestRest) {
                if ($requestRest->wait_start_rest && $requestRest->wait_finish_rest) {
                    Rest::create([
                        'attendance_id' => $id,
                        'start_rest' => $requestRest->wait_start_rest,
                        'finish_rest' => $requestRest->wait_finish_rest,
                        //total_rest再計算
                    ]);
                }
            }


            //work_requests テーブルの更新
            $workRequest = WorkRequest::where('attendance_id', $id)->firstOrFail();
            $workRequest->update(['request_flg' => 1]);
        });

        return redirect()->back()->with('status', '承認済み');
    }
}
