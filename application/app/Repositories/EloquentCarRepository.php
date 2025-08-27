<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\CarMark;
use App\Models\CarModel;
use App\Models\UserCar;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EloquentCarRepository implements CarRepository
{
    public function findCarMarks(): Collection
    {
        $user = Auth::user();

        return CarMark::with('carModels')
            ->orderBy('name')
            ->get();
    }

    public function findCarModels(): Collection
    {
        return CarModel::orderBy('name')->get();
    }

    public function findCars(array $filters): LengthAwarePaginator
    {
        
        $query = Car::with(['carMark', 'carModel', 'users']);

        // Фильтрация по марке
        if (array_key_exists('car_mark_id', $filters)) {
            $query->where('car_mark_id', $filters['car_mark_id']);
        }

        // Фильтрация по модели
        if (array_key_exists('car_model_id', $filters)) {
            $query->where('car_model_id', $filters['car_model_id']);
        }

        // Фильтрация по году
        if (array_key_exists('year', $filters)) {
            $query->where('year', $filters['year']);
        }

        // Фильтрация по диапазону годов
        if (array_key_exists('year_from', $filters)) {
            $query->where('year', '>=', $filters['year_from']);
        }

        if (array_key_exists('year_to', $filters)) {
            $query->where('year', '<=', $filters['year_to']);
        }

        // Сортировка
        $sortField = 'year';
        $sortDirection = 'desc';
        if (array_key_exists('sort_by', $filters)) {
            $sortField = $filters['sort_by'];
        }
        if (array_key_exists('sort_dir', $filters)) {
            $sortDirection = $filters['sort_dir'];
        }
        
        $query->orderBy($sortField, $sortDirection);

        $perPage = $filters['per_page'] ?? 15;

        $cars = $query->paginate($perPage);

        return $cars;
    }

    public function create(array $carAttributes): Car
    {
        $car = Car::create(
            [
                'car_mark_id' => $carAttributes['car_mark_id'],
                'car_model_id' => $carAttributes['car_model_id'],
                'year' => $carAttributes['year'],
                'mileage' => $carAttributes['mileage'],
                'color' => $carAttributes['color']
            ]
        );
        
        return $car;
    }

    public function attachToUser(int $carId, int $userId): void
    {
        UserCar::updateOrCreate([
            'car_id' => $carId,
            'user_id' => $userId
        ]);
    }

    public function findById(int $id): ?Car
    {
        return Car::find($id);
    }

    public function save(Car $car): void
    {
        $car->save();
    }

    public function delete(int $id): void
    {
        Car::destroy($id);
    }

    public function createIfNotExistsMark(string $name): CarMark
    {
        return CarMark::firstOrCreate(['name' => $name]);
    }
    
    public function createIfNotExistsModel(int $carMarkId, string $name): CarModel
    {
        return CarModel::firstOrCreate(['name' => $name, 'car_mark_id' => $carMarkId]);
    }
}
