<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarModelResource;
use App\Repositories\CarRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarModelController extends Controller
{
    public function index(CarRepository $repository): AnonymousResourceCollection
    {
        $carModels = $repository->findCarModels();

        return CarModelResource::collection($carModels);
    }
}
