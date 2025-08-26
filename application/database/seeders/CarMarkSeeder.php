<?php

namespace Database\Seeders;

use App\Models\CarMark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarMark::factory()
            ->count(10)
            ->create();
    }
}
