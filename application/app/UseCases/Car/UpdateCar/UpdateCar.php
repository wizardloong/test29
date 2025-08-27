<?php

namespace App\UseCases\Car\UpdateCar;

use App\Models\Car;
use App\Repositories\CarRepository;
use App\UseCases\Car\CreateCar\CreateCarRequest;

class UpdateCar
{
    public function __construct(
        private CarRepository $repository
    ) {}

    public function execute(int $carId, CreateCarRequest $request): \App\Http\Resources\CarResource
    {
        $carMark = $this->repository->createIfNotExistsMark($request->car_mark_name);
        $carModel = $this->repository->createIfNotExistsModel($carMark->id, $request->car_model_name);

        $car = $this->repository->findById($carId);
        $car->car_mark_id = $carMark->id;
        $car->car_model_id = $carModel->id;
        $car->year = $request->year;
        $car->mileage = $request->mileage;
        $car->color = $request->color;

        $this->repository->save($car);
        $this->repository->attachToUser($car->id, auth()->id());

        $car->load(['carMark', 'carModel']);

        return new \App\Http\Resources\CarResource($car);
    }
}
