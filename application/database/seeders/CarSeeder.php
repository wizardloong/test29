<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarMark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carModel = CarModel::factory()->for(CarMark::factory())->create();
        Car::factory()
            ->count(10)
            ->for($carModel)
            ->for($carModel->carMark)
            ->create();
    }
}
