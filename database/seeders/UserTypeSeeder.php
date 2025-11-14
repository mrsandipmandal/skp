<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{

    public function run()
    {
        DB::table('user_types')->insert([
            [
                'typ' => 'Admin',
                'userlevel' => -1,
            ],
            [
                'typ' => 'Super Admin',
                'userlevel' => -5,
            ],
            [
                'typ' => 'Users',
                'userlevel' => 1,
            ],
            [
                'typ' => 'Customer',
                'userlevel' => 10,
            ],
        ]);
    }
}

