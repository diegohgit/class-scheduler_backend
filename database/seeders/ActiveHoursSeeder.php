<?php

namespace Database\Seeders;

use App\Models\ActiveHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActiveHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ActiveHour::updateOrCreate(
            ['id' => 1],
            [
                'from'  => '09:00:00',
                'until' => '19:00:00'
            ],
        );
    }
}
