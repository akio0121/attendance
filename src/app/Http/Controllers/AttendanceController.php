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
            return view('attendance.entry', compact('attendance'));
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
                return view('attendance.entry02', compact('attendance'));
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
                return view('attendance.entry03', compact('attendance'));
            }
        }

        //勤怠登録画面(退勤後)を表示する
        if ($attendance) {
            $hasStartWork = !is_null($attendance->start_work);
            $hasFinishWork = !is_null($attendance->finish_work);

            if ($hasStartWork && $hasFinishWork) {
                return view('attendance.entry04', compact('attendance'));
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
        return view('attendance.entry02');
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
        return view('attendance.entry03');
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
            $attendance->save();

            return view('attendance.entry04', compact('attendance'));
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
                $rest->save();
            }
        }

        return view('attendance.entry02', compact('attendance'));
    }
}
