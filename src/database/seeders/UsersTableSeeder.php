<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '山田太郎',
            'email' => 'aaa@bbb.com',
            'password' => Hash::make('aaaaaaaa'),
            'admin_flg' => 1
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '鈴木一郎',
            'email' => 'bbb@ccc.com',
            'password' => Hash::make('bbbbbbbb'),
            'admin_flg' => 0
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '佐藤二郎',
            'email' => 'ccc@ddd.com',
            'password' => Hash::make('cccccccc'),
            'admin_flg' => 0
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '田中三郎',
            'email' => 'ddd@eee.com',
            'password' => Hash::make('dddddddd'),
            'admin_flg' => 0
        ];
        DB::table('users')->insert($param);
    }
}
