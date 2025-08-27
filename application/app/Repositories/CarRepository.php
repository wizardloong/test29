<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\CarMark;
use App\Models\CarModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CarRepository
{
    public function findCarMarks(): Collection;
    public function findCarModels(): Collection;
    public function findCars(array $filters): LengthAwarePaginator;

    public function create(array $carAttributes): Car;
    public function attachToUser(int $carId, int $userId): void;
    public function findById(int $id): ?Car;
    public function save(Car $car): void;

    public function delete(int $id): void;

    public function createIfNotExistsMark(string $name): CarMark;
    public function createIfNotExistsModel(int $carMarkId, string $name): CarModel;
}
