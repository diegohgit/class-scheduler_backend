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
        $colors = [ '#f87171',
                    '#fbbf24',
                    '#fde047',
                    '#bef264',
                    '#34d399',
                    '#5eead4',
                    '#60a5fa',
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
