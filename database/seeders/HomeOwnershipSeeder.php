<?php

namespace Database\Seeders;

use App\Models\HomeOwnership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeOwnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeOwnership::insert([
            ['name' => 'Owned'],
            ['name' => 'Rented'],
            ['name' => 'Living w/ Parents']
        ]);
    }
}
