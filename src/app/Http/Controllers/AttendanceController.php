<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
use App\Models\RequestAttendance;
use App\Models\RequestRest;
use App\Models\WorkRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AttendanceRequest;


class AttendanceController extends Controller
{

    //ログイン後、勤務状態を取得して状態に応じた出勤登録画面を表示する
    public function showEntry()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->with('rests')
            ->first();

        //勤怠登録画面(出勤前)を表示する
        if (!$attendance) {
            return view('attendance.show_entry', compact('attendance'));
        }

        // 勤怠登録画面(出勤後)を表示する
        if ($attendance) {
            $startWorkExists = !is_null($attendance->start_work);
            $finishWorkEmpty = is_null($attendance->finish_work);

            $rests = $attendance->rests;

            // 休憩が未開始（start_restが1件もない）
            $hasNotStartedRest = !$rests->contains(function ($rest) {
                return !is_null($rest->start_rest);
            });

            // 最後の休憩が終了している（start_rest, finish_rest の両方が入ってる休憩がある）
            $lastRestFinished = $rests->contains(function ($rest) {
                return !is_null($rest->start_rest) && !is_null($rest->finish_rest);
            });

            if ($startWorkExists && $finishWorkEmpty && ($hasNotStartedRest || $lastRestFinished)) {
                return view('attendance.start_work', compact('attendance'));
            }
        }

        //勤怠登録画面(休憩中)を表示する
        if ($attendance) {
            $startWorkExists = !is_null($attendance->start_work);
            $finishWorkEmpty = is_null($attendance->finish_work);
            $hasStartedRest = $attendance->rests->contains(function ($rest) {
                return !is_null($rest->start_rest);
            });

            if ($startWorkExists && $finishWorkEmpty && $hasStartedRest) {
                return view('attendance.start_rest', compact('attendance'));
            }
        }

        //勤怠登録画面(退勤後)を表示する
        if ($attendance) {
            $hasStartWork = !is_null($attendance->start_work);
            $hasFinishWork = !is_null($attendance->finish_work);

            if ($hasStartWork && $hasFinishWork) {
                return view('attendance.finish_work', compact('attendance'));
            }
        }
    }

    //出勤登録画面で、出勤ボタンを押下して出勤時刻を記録する
    public function startWork()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->format('H:i:s');
        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if (!$attendance) {
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'start_work' => $now,
            ]);
        }
        return view('attendance.start_work');
    }

    //出勤登録画面で、休憩入ボタンを押下して休憩開始時刻を記録する
    public function startRest()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($attendance && $attendance->start_work !== null && $attendance->finish_work === null) {
            Rest::create([
                'attendance_id' => $attendance->id,
                'start_rest' => Carbon::now(),
                'finish_rest' => null,
                'total_rest' => null,
            ]);
        }
        return view('attendance.start_rest');
    }

    //出勤登録画面で、退勤ボタンを押下して退勤時刻を記録する
    public function finishWork()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($attendance && is_null($attendance->finish_work)) {
            $attendance->finish_work = Carbon::now()->toTimeString();

            // 勤務時間（分）を算出し、total_work に保存
            $start = Carbon::parse($attendance->start_work);
            $finish = Carbon::parse($attendance->finish_work);
            $totalMinutes = $start->diffInMinutes($finish);
            $attendance->total_work = $totalMinutes;
            $attendance->save();

            return view('attendance.finish_work', compact('attendance'));
        }
    }

    //出勤登録画面で、休憩戻ボタンを押下して休憩終了時刻を記録する
    public function finishRest()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($attendance) {
            $rest = $attendance->rests()
                ->whereNull('finish_rest') //終了していない休憩が対象
                ->orderByDesc('start_rest') //休憩開始時刻が新しい順に並べる
                ->first(); //最新の休憩1件を取得

            if ($rest) {
                $rest->finish_rest = Carbon::now()->toTimeString();
                // start_rest から finish_rest までの時間差（分単位）を計算
                $startRest = Carbon::parse($rest->start_rest);
                $finishRest = Carbon::parse($rest->finish_rest);
                $totalRestMinutes = $startRest->diffInMinutes($finishRest);

                $rest->total_rest = $totalRestMinutes;
                $rest->save();
            }
        }

        return view('attendance.start_work', compact('attendance'));
    }

    //勤怠一覧画面を表示する
    public function showList(Request $request)
    {
        /** @var \App\Models\User $user */
        //ログインしたユーザーの、attendancesテーブル、restsテーブルのデータを取得する
        $user = Auth::user();
        Carbon::setLocale('ja');
        $attendances = $user->attendances()->with('rests')->get();

        //現在の月を取得する
        $currentMonth = $request->input('month', Carbon::now()->format('Y-m'));
        //対象月の開始、終了日を取得する
        $startOfMonth = Carbon::createFromFormat('Y-m', $currentMonth)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // その月の全日付を取得
        $daysInMonth = [];
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $daysInMonth[] = $date->copy();
        }
        // 該当月のデータのみ取得
        $attendances = $user->attendances()
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->with('rests')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');


        foreach ($attendances as $attendance) {
            //休憩を複数回取った場合、合計時間を表示する
            $attendance->total_rest_minutes = $attendance->rests->sum('total_rest');
            //attendancesテーブルのtotal_workからrestsテーブルのtotal_restをマイナスする
            $netWorkMinutes = $attendance->total_work - $attendance->total_rest_minutes;
            $attendance->net_work_minutes = max($netWorkMinutes, 0);
        }

        // 前月・翌月を算出する
        $previousMonth = $startOfMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $startOfMonth->copy()->addMonth()->format('Y-m');

        return view('attendance.list', compact('attendances', 'currentMonth', 'previousMonth', 'nextMonth', 'daysInMonth'));
    }

    //勤怠詳細画面を表示する
    public function showDetail($id)
    {
        //$user = Auth::user();
        //$attendance = Attendance::with(['rests', 'workRequest.requestRests'])->findOrFail($id);
        $attendance = Attendance::with(['user', 'rests', 'workRequest.requestRests'])->findOrFail($id);

        //勤怠を修正申請中の場合
        if ($attendance->workRequest && $attendance->workRequest->request_flg === 0) {
            //return view('attendance.request_detail', compact('user', 'attendance'));
            return view('attendance.request_detail', compact('attendance'));
        }

        //勤怠を修正申請中ではない場合
        //return view('attendance.detail', compact('user', 'attendance'));
        return view('attendance.detail', compact('attendance'));
    }

    //勤怠詳細画面で、勤務内容を修正する
    public function updateDetail(AttendanceRequest $request, $attendanceId)
    {
        //該当の勤怠データ取得
        $attendance = Attendance::findOrFail($attendanceId);

        //勤務時間の修正リクエストを保存
        //request_attendance の取得または新規作成
        $requestAttendance = $attendance->requestAttendance;
        if (!$requestAttendance) {
            $requestAttendance = new RequestAttendance();
            $requestAttendance->attendance_id = $attendance->id;
        }

        // フォームから送られてきたstart_workを、wait_start_workに保存
        $requestAttendance->wait_start_work = $request->input('start_work');
        $requestAttendance->wait_finish_work = $request->input('finish_work');
        $requestAttendance->notes = $request->input('notes');
        $requestAttendance->save();

        // フォームから送られてきた休憩データを取得
        $rests = $request->input('rests', []);

        foreach ($rests as $restData) {
            // 値が存在する場合のみ保存
            if (!empty($restData['start_rest']) && !empty($restData['finish_rest'])) {
                $requestRest = new RequestRest();
                $requestRest->request_attendance_id = $requestAttendance->id;
                $requestRest->wait_start_rest = $restData['start_rest'];
                $requestRest->wait_finish_rest = $restData['finish_rest'];
                $requestRest->save();
            }
        }
        //work_requestsテーブルに申請日時、申請フラグ等を保存する
        $workRequest = $attendance->request;
        if (!$workRequest) {
            $workRequest = new WorkRequest();
            $workRequest->attendance_id = $attendance->id;
            $workRequest->request_date = Carbon::now();
            $workRequest->request_flg = 0;
            $workRequest->save();
        }
        return redirect('attendance/list');
    }

    //勤怠一覧画面(管理者)を表示する
    public function adminShowList(Request $request)
    {
        $date = $request->query('date', Carbon::now()->format('Y-m-d'));

        //管理者以外のユーザーidを取り出して、配列化する
        $userIds = User::where('admin_flg', 0)->pluck('id');

        $attendances = Attendance::whereIn('user_id', $userIds)
            ->whereDate('date', $date)
            ->with(['user', 'rests'])
            ->get();

        $previousDate = Carbon::parse($date)->subDay()->format('Y-m-d');
        $nextDate = Carbon::parse($date)->addDay()->format('Y-m-d');


        return view('attendance.admin_list', compact('attendances', 'date', 'previousDate', 'nextDate'));
    }
}
