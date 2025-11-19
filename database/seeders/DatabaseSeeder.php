<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SignupSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(DeliveryTypeSeeder::class);

        // \App\Models\User::factory(10)->create();
    }
}
