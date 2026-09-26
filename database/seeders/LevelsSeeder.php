<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [ 'A1',
                    'A2',
                    'B1',
                    'B2',
                    'C1',
                    'C2',];

        //If a day already exists, do nothing.
        foreach($levels as $level){
            Level::firstOrCreate([
                'name' => $level,
            ]);
        }
    }
}
