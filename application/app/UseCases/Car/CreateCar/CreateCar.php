<?php

namespace App\UseCases\Car\CreateCar;

use App\Http\Resources\CarResource;
use App\Repositories\CarRepository;

class CreateCar 
{
    public function __construct(
        private CarRepository $repository
    ) {}

    public function execute(CreateCarRequest $request): CarResource
    {
        $carMark = $this->repository->createIfNotExistsMark($request->car_mark_name);
        $carModel = $this->repository->createIfNotExistsModel($carMark->id, $request->car_model_name);

        $carAttributes = [
            'car_mark_id' => $carMark->id,
            'car_model_id' => $carModel->id,
            'year' => $request->year,
            'mileage' => $request->mileage,
            'color' => $request->color
        ];

        $car = $this->repository->create($carAttributes);
        $this->repository->attachToUser($car->id, auth()->id());

        $car->load(['carMark', 'carModel']);

        return new CarResource($car);
    }
}
