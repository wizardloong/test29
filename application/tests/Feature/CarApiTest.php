<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\CarMark;
use App\Models\CarModel;
use App\Models\UserCar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarApiTest extends TestCase
{
    use RefreshDatabase;

    private function authUser()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    /** @test */
    public function user_can_list_his_cars()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $carModel = CarModel::factory()->for(CarMark::factory())->create();

        $car = Car::factory()
            ->for($carModel)
            ->for($carModel->carMark)
            ->count(3)
            ->create();

        foreach ($car as $c) {
            UserCar::factory()
                ->for($user)
                ->for($c)
                ->create();
        }

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->getJson('/api/cars');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function user_can_create_car()
    {
        $headers = $this->authUser();

        $mark = CarMark::factory()->create();
        $model = CarModel::factory()->create(['car_mark_id' => $mark->id]);

        $response = $this->withHeaders($headers)->postJson('/api/cars', [
            'car_mark_name' => $mark->name,
            'car_model_name' => $model->name,
            'year' => 2020,
            'mileage' => 50000,
            'color' => 'red',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['id', 'car_mark' => ['id'], 'car_model' => ['id']]]);
    }

    /** @test */
    public function user_can_update_his_car()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $carModel = CarModel::factory()->for(CarMark::factory())->create();

        $car = Car::factory()
            ->for($carModel)
            ->for($carModel->carMark)
            ->create();

        UserCar::factory()
            ->for($user)
            ->for($car)
            ->create();
        
        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->putJson("/api/cars/{$car->id}", [
                             'color' => 'blue'
                         ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['color' => 'blue']);
    }

    /** @test */
    public function user_cannot_update_foreign_car()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $carModel = CarModel::factory()->for(CarMark::factory())->create();

        $car = Car::factory()
            ->for($carModel)
            ->for($carModel->carMark)
            ->create(); // чужая машина

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->putJson("/api/cars/{$car->id}", ['color' => 'black']);

        $response->assertStatus(403); // доступ запрещён
    }

    /** @test */
    public function user_can_delete_his_car()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $carModel = CarModel::factory()->for(CarMark::factory())->create();

        $car = Car::factory()
            ->for($carModel)
            ->for($carModel->carMark)
            ->create();

        UserCar::factory()
            ->for($user)
            ->for($car)
            ->create();

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->deleteJson("/api/cars/{$car->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }
}
