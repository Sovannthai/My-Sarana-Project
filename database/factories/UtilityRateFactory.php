<?php

namespace Database\Factories;

use App\Models\UtilityRate;
use App\Models\UtilityType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UtilityRate>
 */
class UtilityRateFactory extends Factory
{
    protected $model = UtilityRate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'utility_type_id' => UtilityType::factory(),  // Creates related UtilityType
            'rate_per_unit' => $this->faker->randomFloat(2, 0.05, 1.00), // Random rate between 0.05 and 1.00
        ];
    }
}
