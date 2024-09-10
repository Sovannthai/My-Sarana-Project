<?php

namespace Database\Factories;

use App\Models\PriceAdjustment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceAdjustmentFactory extends Factory
{
    protected $model = PriceAdjustment::class;

    public function definition()
    {
        return [
            'room_id' => \App\Models\Room::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 100),
            'reason' => $this->faker->sentence(),
            'startdate' => $this->faker->date(),
            'enddate' => $this->faker->optional()->date(),
        ];
    }
}
