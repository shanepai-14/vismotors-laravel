<?php

namespace Database\Seeders;

use App\Models\MotorType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MotorType::insert([
            ['name' => 'Brand New'],
            ['name' => 'Repo']
        ]);
    }
}
