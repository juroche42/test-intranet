<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
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
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
        ]);

        $users = User::all();
        $services = Service::all();

        foreach ($users as $user) {
            $numberOfServices = rand(1, 3);
            $randomServices = $services->random($numberOfServices);
            $user->services()->attach($randomServices);
        }

    }
}
