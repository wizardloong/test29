<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarStoreRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\CarMark;
use App\Repositories\CarRepository;
use App\UseCases\Car\CreateCar\CreateCar;
use App\UseCases\Car\CreateCar\CreateCarRequest;
use App\UseCases\Car\DestroyCar\DestroyCar;
use App\UseCases\Car\UpdateCar\UpdateCar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarController extends Controller
{
    /**
     * Display a listing of the cars.
     */
    public function index(Request $request, CarRepository $repository): AnonymousResourceCollection
    {
        $cars = $repository->findCars($request->all());

        return CarResource::collection($cars);
    }

    /**
     * Store a newly created car in storage.
     */
    public function store(CarStoreRequest $httpRequest, CreateCar $createCar): JsonResponse|CarResource
    {
        try {
            $request = new CreateCarRequest(
                car_mark_name: $httpRequest->car_mark_name,
                car_model_name: $httpRequest->car_model_name,
                year: $httpRequest->year,
                mileage: $httpRequest->mileage,
                color: $httpRequest->color
            );

            $response = $createCar->execute($request);

            return $response;
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car): CarResource
    {
        $car->load(['carMark', 'carModel', 'users']);

        return new CarResource($car);
    }

    /**
     * Update the specified car in storage.
     */
    public function update(CarUpdateRequest $httpRequest, Car $car, UpdateCar $updateCar): CarResource|JsonResponse
    {
        try {
            $request = new CreateCarRequest(
                car_mark_name: $httpRequest->car_mark_name,
                car_model_name: $httpRequest->car_model_name,
                year: $httpRequest->year,
                mileage: $httpRequest->mileage,
                color: $httpRequest->color
            );

            $response = $updateCar->execute($car->id, $request);

            return $response;
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified car from storage.
     */
    public function destroy(Car $car, DestroyCar $destroyCar): JsonResponse
    {        
        try {
            $destroyCar->execute($car->id);

            return response()->json([
                'message' => 'Car deleted successfully'
            ], 200);

            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get available filters for cars.
     */
    public function filters(): JsonResponse
    {
        $filters = [
            'marks' => CarMark::select('id', 'name')->orderBy('name')->get(),
            'years' => Car::select('year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
        ];

        return response()->json($filters);
    }
}
