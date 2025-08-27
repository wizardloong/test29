<?php

namespace Tests\Feature;

use App\Models\CarMark;
use App\Models\CarModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarMarksModelsApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_car_marks()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        CarMark::factory()->count(3)->create();

        $response = $this->withHeader('Authorization', "Bearer $token")->getJson('/api/car-marks');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => [0 => ['id', 'name', 'models']]]);
    }

    /** @test */
    public function it_returns_car_models()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $mark = CarMark::factory()->create();
        CarModel::factory()->count(3)->create(['car_mark_id' => $mark->id]);

        $response = $this->withHeader('Authorization', "Bearer $token")->getJson('/api/car-models');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => [0 => ['id', 'name']]]);
    }
}
