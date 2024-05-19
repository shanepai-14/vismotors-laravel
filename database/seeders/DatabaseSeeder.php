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
            UserSeeder::class,
            GenderSeeder::class,
            CivilStatusSeeder::class,
            OccupationSeeder::class,
            TransactionTypeSeeder::class,
            BrandSeeder::class,
            StatusSeeder::class,
            CitizenshipSeeder::class,
            HomeOwnershipSeeder::class,
            MotorTypeSeeder::class
        ]);
    }
}
