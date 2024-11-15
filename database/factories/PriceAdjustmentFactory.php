<?php

namespace Database\Factories;

use App\Models\PriceAdjustment;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceAdjustmentFactory extends Factory
{
    protected $model = PriceAdjustment::class;

    public function definition()
    {
        return [
            'room_id' => Room::factory(),
            'percentage' => $this->faker->randomFloat(2, 1, 50),
            'description' => $this->faker->optional()->text(100),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
