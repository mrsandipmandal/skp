<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\DeliveryType::create(['name' => 'Self Pickup', 'stat' => 0]);
        \App\Models\DeliveryType::create(['name' => 'Delivery', 'stat' => 0]);
    }
}
