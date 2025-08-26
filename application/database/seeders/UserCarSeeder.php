<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarMark;
use App\Models\UserCar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carModel = CarModel::factory()->for(CarMark::factory())->create();

        $car = Car::factory()
            ->for($carModel)
            ->for($carModel->carMark)
            ->create();

        UserCar::factory()
            ->count(10)
            ->for(User::factory())
            ->for($car)
            ->create();
    }
}
