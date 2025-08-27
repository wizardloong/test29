<?php

namespace App\UseCases\Car\UpdateCar;

use App\Http\Resources\CarResource;
use App\Repositories\CarRepository;
use App\UseCases\Car\UpdateCar\UpdateCarRequest;

class UpdateCar
{
    public function __construct(
        private CarRepository $repository
    ) {}

    public function execute(int $carId, UpdateCarRequest $request): CarResource
    {
        $car = $this->repository->findById($carId);

        if (!empty($request->car_mark_name)){
            $carMark = $this->repository->createIfNotExistsMark($request->car_mark_name);
            $car->car_mark_id = $carMark->id;
        }

        if (!empty($request->car_model_name)){     
            $carModel = $this->repository->createIfNotExistsModel($carMark->id, $request->car_model_name);
            $car->car_model_id = $carModel->id;
        }
        
        $car->year = $request->year;
        $car->mileage = $request->mileage;
        $car->color = $request->color;

        $this->repository->save($car);
        $this->repository->attachToUser($car->id, auth()->id());

        $car->load(['carMark', 'carModel']);

        return new CarResource($car);
    }
}
