<?php

namespace Database\Seeders;

use Database\Seeders\ActiveHoursSeeder;
use Database\Seeders\ColorsSeeder;
use Database\Seeders\DaysSeeder;
use Database\Seeders\LevelsSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([ActiveHoursSeeder::class,
                    ColorsSeeder::class,
                    DaysSeeder::class,
                    LevelsSeeder::class,]);
    }
}
