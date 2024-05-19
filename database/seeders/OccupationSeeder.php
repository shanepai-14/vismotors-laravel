<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Occupation::insert([
            ['name' => 'Govt. Employee'],
            ['name' => 'Govt. Official'],
            ['name' => 'Private Employee'],
            ['name' => 'Part Time Employee'],
            ['name' => 'Self Employed'],
            ['name' => 'Student'],
            ['name' => 'Unemployed']
        ]);
    }
}
