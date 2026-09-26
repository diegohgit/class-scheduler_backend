<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['#f87171',
                    '#fbbf24',
                    '#fde047',
                    '#bef264',
                    '#5eead4',
                    '#67e8f9',
                    '#3b82f6',
                    '#a5b4fc',
                    '#f0abfc',];

        //If a day already exists, do nothing.
        foreach($colors as $color){
            Color::firstOrCreate([
                'name' => $color,
            ]);
        }
    }
}
