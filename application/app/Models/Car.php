<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    protected $fillable = [
        'car_mark_id',
        'car_model_id',
        'year',
        'mileage',
        'color'
    ];

    public function carMark(): BelongsTo
    {
        return $this->belongsTo(CarMark::class);
    }

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserCar::class);
    }
}
