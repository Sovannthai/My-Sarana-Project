<?php

namespace Database\Factories;

use App\Models\UtilityType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UtilityType>
 */
class UtilityTypeFactory extends Factory
{
    protected $model = UtilityType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['Electricity', 'Water', 'Gas']),
        ];
    }
}
