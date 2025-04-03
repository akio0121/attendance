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
        if ($attendance && $attendance->start_work !== null && $attendance->finish_work === null) {
            return view('attendance.entry02', compact('attendance'));
        }

        
        //勤怠登録画面(休憩中)を表示する

        //勤怠登録画面(退勤後)を表示する

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
        //return view('attendance.entry03');
    }
}
