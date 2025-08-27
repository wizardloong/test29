<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarMarkResource;
use App\Repositories\CarRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarMarkController extends Controller
{
    public function index(CarRepository $repository): AnonymousResourceCollection
    {
        $carMarks = $repository->findCarMarks();

        return CarMarkResource::collection($carMarks);
    }
}
