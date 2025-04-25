<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'attendance_id' => 1,
            'start_rest' => '12:00:00',
            'finish_rest' => '13:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 2,
            'start_rest' => '13:00:00',
            'finish_rest' => '14:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 2,
            'start_rest' => '15:00:00',
            'finish_rest' => '16:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 4,
            'start_rest' => '13:00:00',
            'finish_rest' => '13:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 5,
            'start_rest' => '14:00:00',
            'finish_rest' => '15:15:00',
            'total_rest' => 75
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 6,
            'start_rest' => '15:00:00',
            'finish_rest' => '16:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 7,
            'start_rest' => '16:00:00',
            'finish_rest' => '17:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 8,
            'start_rest' => '13:00:00',
            'finish_rest' => '14:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 9,
            'start_rest' => '14:00:00',
            'finish_rest' => '15:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 10,
            'start_rest' => '15:00:00',
            'finish_rest' => '16:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 11,
            'start_rest' => '16:00:00',
            'finish_rest' => '17:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 12,
            'start_rest' => '17:00:00',
            'finish_rest' => '18:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 13,
            'start_rest' => '18:00:00',
            'finish_rest' => '19:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 14,
            'start_rest' => '19:00:00',
            'finish_rest' => '20:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 15,
            'start_rest' => '20:00:00',
            'finish_rest' => '21:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 16,
            'start_rest' => '10:00:00',
            'finish_rest' => '11:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 17,
            'start_rest' => '11:00:00',
            'finish_rest' => '12:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 18,
            'start_rest' => '12:00:00',
            'finish_rest' => '13:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 19,
            'start_rest' => '13:00:00',
            'finish_rest' => '14:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 20,
            'start_rest' => '14:00:00',
            'finish_rest' => '15:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 21,
            'start_rest' => '15:00:00',
            'finish_rest' => '16:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 22,
            'start_rest' => '16:00:00',
            'finish_rest' => '17:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 23,
            'start_rest' => '17:00:00',
            'finish_rest' => '18:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 24,
            'start_rest' => '18:00:00',
            'finish_rest' => '19:30:00',
            'total_rest' => 90
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 25,
            'start_rest' => '10:00:00',
            'finish_rest' => '10:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 26,
            'start_rest' => '11:00:00',
            'finish_rest' => '11:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 27,
            'start_rest' => '12:00:00',
            'finish_rest' => '12:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 28,
            'start_rest' => '13:00:00',
            'finish_rest' => '13:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 29,
            'start_rest' => '14:00:00',
            'finish_rest' => '14:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 30,
            'start_rest' => '15:00:00',
            'finish_rest' => '15:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 31,
            'start_rest' => '16:00:00',
            'finish_rest' => '16:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 32,
            'start_rest' => '17:00:00',
            'finish_rest' => '17:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 32,
            'start_rest' => '18:00:00',
            'finish_rest' => '18:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 32,
            'start_rest' => '19:00:00',
            'finish_rest' => '19:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 33,
            'start_rest' => '20:00:00',
            'finish_rest' => '20:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 34,
            'start_rest' => '21:00:00',
            'finish_rest' => '21:30:00',
            'total_rest' => 30
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 35,
            'start_rest' => '12:00:00',
            'finish_rest' => '13:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 36,
            'start_rest' => '13:00:00',
            'finish_rest' => '14:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 37,
            'start_rest' => '14:00:00',
            'finish_rest' => '15:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 38,
            'start_rest' => '15:00:00',
            'finish_rest' => '16:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 39,
            'start_rest' => '16:00:00',
            'finish_rest' => '17:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'attendance_id' => 40,
            'start_rest' => '17:00:00',
            'finish_rest' => '18:00:00',
            'total_rest' => 60
        ];
        DB::table('rests')->insert($param);
    }
}
