<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
                /* Required */
            CountriesSeeder::class,
            StatesSeeder::class,
            CitiesSeeder::class,
            InterestSeeder::class,
            PermissionSeeder::class,

                /* Optional */
            UserSeeder::class,
            ProductSeeder::class,

        ]);
    }
}
