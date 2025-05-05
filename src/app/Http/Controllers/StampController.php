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
use Carbon\Carbon;

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

        // ログインユーザーからレイアウト判定
        $authUser = Auth::user();
        $layout = $authUser->admin_flg === 1 ? 'layouts.admin_app' : 'layouts.app';

        // 承認ページを表示
        return view('attendance.request_detail', compact('attendance', 'layout'));
    }

    //修正申請承認画面(管理者)で、修正申請された勤怠を承認する
    public function approveRequest($id)
    {
        DB::transaction(function () use ($id) {
            //request_attendancesテーブルを取得
            $requestAttendance = RequestAttendance::with('requestRests')->where('attendance_id', $id)->firstOrFail();

            // start_work と finish_work の差分を計算（分単位）
            $startWork = Carbon::parse($requestAttendance->wait_start_work);
            $finishWork = Carbon::parse($requestAttendance->wait_finish_work);
            $totalWorkMinutes = $finishWork->diffInMinutes($startWork);
            //attendancesテーブルの更新
            $attendance = Attendance::findOrFail($id);
            $attendance->update([
                'start_work' => $startWork,
                'finish_work' => $finishWork,
                'notes' => $requestAttendance->notes,
                'total_work' => $totalWorkMinutes,
            ]);

            //rests テーブルの更新（既存削除＞再登録）
            Rest::where('attendance_id', $id)->delete();

            foreach ($requestAttendance->requestRests as $requestRest) {
                if ($requestRest->wait_start_rest && $requestRest->wait_finish_rest) {
                    Rest::create([
                        'attendance_id' => $id,
                        'start_rest' => $requestRest->wait_start_rest,
                        'finish_rest' => $requestRest->wait_finish_rest,
                        'total_rest' => Carbon::parse($requestRest->wait_finish_rest)
                            ->diffInMinutes(Carbon::parse($requestRest->wait_start_rest)),

                    ]);
                }
            }

            //work_requests テーブルの更新
            $workRequest = WorkRequest::where('attendance_id', $id)->firstOrFail();
            $workRequest->update(['request_flg' => 1]);
        });

        return redirect()->back()->with('status', '承認済み');
    }


    //申請一覧画面(管理者)で、申請データを承認待ちor承認済みに切り替える
    public function showAdminRequestList(Request $request)
    {
        // 'status'のデフォルト値を'waiting'に設定
        $status = $request->input('status', 'waiting');

        // request_flgが0の場合（承認待ち）
        if ($status === 'waiting') {
            $attendances = Attendance::whereHas('workRequest', function ($query) {
                $query->where('request_flg', 0); // WorkRequestのrequest_flgが0の場合
            })->get();
        } elseif ($status === 'approved') {
            // request_flgが1の場合（承認済み）
            $attendances = Attendance::whereHas('workRequest', function ($query) {
                $query->where('request_flg', 1); // WorkRequestのrequest_flgが1の場合
            })->get();
        } else {
            // その他の場合（全てのリクエストを取得）
            $attendances = Attendance::with('workRequest')->get();
        }

        // status と attendances をビューに渡す
        return view('stamp.admin_request', compact('attendances', 'status'));
    }

    //申請一覧画面(一般ユーザー)で、承認待ちor承認済み勤怠の表示を切り替える
    public function showRequestList(Request $request)
    {
        // 'status'のデフォルト値を'waiting'に設定
        $status = $request->input('status', 'waiting');  // デフォルトは 'waiting'
        $user = Auth::user(); // ログインユーザーを取得

        // 'status'によって表示する勤怠情報を変更（ログインユーザー限定）
        if ($status === 'waiting') {
            $attendances = Attendance::where('user_id', $user->id)
                ->whereHas('workRequest', function ($query) {
                    $query->where('request_flg', 0);
                })->with('workRequest')->get();
        } elseif ($status === 'approved') {
            $attendances = Attendance::where('user_id', $user->id)
                ->whereHas('workRequest', function ($query) {
                    $query->where('request_flg', 1);
                })->with('workRequest')->get();
        } else {
            // その他の場合はすべて取得（ログインユーザーに限定）
            $attendances = Attendance::where('user_id', $user->id)
                ->with('workRequest')->get();
        }

        // ビューに渡す
        return view('stamp.show_request', compact('attendances', 'status'));
    }
}
