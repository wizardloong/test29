<?php

namespace App\UseCases\Car\UpdateCar;

class UpdateCarRequest
{
    public function __construct(
        public ?string $car_mark_name,
        public ?string $car_model_name,
        public ?int $year,
        public ?float $mileage,
        public ?string $color
    ) {}
}
