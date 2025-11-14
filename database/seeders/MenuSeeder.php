<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        DB::table('menus')->insert([
            [
                'menu_name' => 'Dashboard',
                'route_name' => 'dashboard',
                'root_menu' => 0,
                'ordr' => 1,
                'icon' => 'dashboard-line',
                'user' => '',
                'isall' => 1,
                'stat' => 0,
                'is_edit' => 0,
                'is_delete' => 0,
                'is_active' => 0,
                'is_export' => 0,
                'eby' => 'admin',
            ],
            [
                'menu_name' => 'Setup',
                'route_name' => '#',
                'root_menu' => 0,
                'ordr' => 2,
                'icon' => 'settings-3-line',
                'user' => '',
                'isall' => 1,
                'stat' => 0,
                'is_edit' => 0,
                'is_delete' => 0,
                'is_active' => 0,
                'is_export' => 0,
                'eby' => 'admin',
            ],
            [
                'menu_name' => 'Entry',
                'route_name' => '#',
                'root_menu' => 0,
                'ordr' => 3,
                'icon' => 'edit-line',
                'user' => '',
                'isall' => 1,
                'stat' => 0,
                'is_edit' => 0,
                'is_delete' => 0,
                'is_active' => 0,
                'is_export' => 0,
                'eby' => 'admin',
            ],
            [
                'menu_name' => 'Menu Setup',
                'route_name' => '#',
                'root_menu' => 0,
                'ordr' => 4,
                'icon' => 'layout-3-line',
                'user' => '-5',
                'isall' => 0,
                'stat' => 0,
                'is_edit' => 1,
                'is_delete' => 1,
                'is_active' => 1,
                'is_export' => 1,
                'eby' => 'admin',
            ],
            [
                'menu_name' => 'Role Management',
                'route_name' => 'menu-setup',
                'root_menu' => 4,
                'ordr' => 2,
                'icon' => '',
                'user' => '',
                'isall' => 1,
                'stat' => 0,
                'is_edit' => 1,
                'is_delete' => 1,
                'is_active' => 1,
                'is_export' => 1,
                'eby' => 'admin',
            ],
        ]);
    }
}
