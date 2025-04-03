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
    }
}
