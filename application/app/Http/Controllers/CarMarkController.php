<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CarMarkResource;
use App\Models\CarMark;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarMarkController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $carMarks = CarMark::with('carModels')
            ->orderBy('name')
            ->get();

        return CarMarkResource::collection($carMarks);
    }
}
