<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


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
        // 該当月のデータのみ取得
        $attendances = $user->attendances()
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->with('rests')
            ->orderBy('date', 'asc')
            ->get();

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

        return view('attendance.list', compact('attendances', 'currentMonth', 'previousMonth', 'nextMonth'));
    }

    //勤怠詳細画面を表示する
    public function showDetail($id)
    {
        $user = Auth::user();
        $attendance = Attendance::with('rests')->findOrFail($id);
        return view('attendance.detail', compact('user', 'attendance'));
    }

    //勤怠詳細画面で、勤務内容を修正する
    public function updateDetail($id)
    {

    }
}
