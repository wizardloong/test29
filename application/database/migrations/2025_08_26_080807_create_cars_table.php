<?php

use App\Models\CarMark;
use App\Models\CarModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            
            // Похоже что это избыточное поле, которое должно дублировать информацию из carModel->carMark
            // Оставляю как есть. Предполагаю, что это было сделанно намеренно для оптимизации выборки.
            $table->foreignIdFor(CarMark::class, 'car_mark_id')->constrained();

            $table->foreignIdFor(CarModel::class, 'car_model_id')->constrained();
            $table->integer('year')->nullable();
            $table->decimal('mileage', 12, 2)->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
