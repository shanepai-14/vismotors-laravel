<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MotorcycleColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['color' => 'Matte Black'],
            ['color' => 'Matte White'],
            ['color' => 'Matte Red'],
            ['color' => 'Matte Blue'],
            ['color' => 'Matte Green'],
            ['color' => 'Matte Yellow'],
            ['color' => 'Matte Orange'],
            ['color' => 'Matte Silver'],
            ['color' => 'Matte Gray'],
            ['color' => 'Matte Purple'],
            ['color' => 'Matte Brown'],
            ['color' => 'Matte Gold'],
            ['color' => 'Matte Pink'],
            ['color' => 'Matte Maroon'],
            ['color' => 'Matte Turquoise'],
            ['color' => 'Metallic Black'],
            ['color' => 'Metallic White'],
            ['color' => 'Metallic Red'],
            ['color' => 'Metallic Blue'],
            ['color' => 'Metallic Green'],
            ['color' => 'Metallic Yellow'],
            ['color' => 'Metallic Orange'],
            ['color' => 'Metallic Silver'],
            ['color' => 'Metallic Gray'],
            ['color' => 'Metallic Purple'],
            ['color' => 'Metallic Brown'],
            ['color' => 'Metallic Gold'],
            ['color' => 'Metallic Pink'],
            ['color' => 'Metallic Maroon'],
            ['color' => 'Metallic Turquoise'],
            ['color' => 'Glossy Black'],
            ['color' => 'Glossy White'],
            ['color' => 'Glossy Red'],
            ['color' => 'Glossy Blue'],
            ['color' => 'Glossy Green'],
            ['color' => 'Glossy Yellow'],
            ['color' => 'Glossy Orange'],
            ['color' => 'Glossy Silver'],
            ['color' => 'Glossy Gray'],
            ['color' => 'Glossy Purple'],
            ['color' => 'Glossy Brown'],
            ['color' => 'Glossy Gold'],
            ['color' => 'Glossy Pink'],
            ['color' => 'Glossy Maroon'],
            ['color' => 'Glossy Turquoise'],
        ];

        DB::table('motorcycle_colors')->insert($colors);
    }
}
