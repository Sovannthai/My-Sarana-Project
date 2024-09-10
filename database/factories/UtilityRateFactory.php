<?php

namespace Database\Factories;

use App\Models\UtilityRate;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilityRateFactory extends Factory
{
    protected $model = UtilityRate::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['Electricity', 'Water']),
            'rateperunit' => $this->faker->randomFloat(2, 100, 500),
        ];
    }
}
