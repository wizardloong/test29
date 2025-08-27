<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'mileage' => $this->mileage,
            'color' => $this->color,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'car_mark' => new CarMarkResource($this->whenLoaded('carMark')),
            'car_model' => new CarModelResource($this->whenLoaded('carModel')),
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
