<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SignupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('main_signup')->insert([
            [
                'username' => 'admin',
                'pass' => '123',
                'password' => '202cb962ac59075b964b07152d234b70',
                'name' => 'Administrator',
                'actnum' => 0,
                'userlevel' => -1,
            ],
            [
                'username' => 'onsadmin',
                'pass' => '123',
                'password' => '202cb962ac59075b964b07152d234b70',
                'name' => 'Super Administrator',
                'actnum' => 0,
                'userlevel' => -5,
            ],
        ]);
    }
}
