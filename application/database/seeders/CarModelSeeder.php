<?php

namespace Database\Seeders;

use App\Models\CarMark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarModel;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarModel::factory()
            ->count(10)
            ->for(CarMark::factory())
            ->create();
    }
}
