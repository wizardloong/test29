<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarMark extends Model
{
    /** @use HasFactory<\Database\Factories\CarMarkFactory> */
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }
}
