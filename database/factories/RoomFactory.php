<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_number' => $this->faker->unique()->numberBetween(100, 999),
            'description' => $this->faker->sentence(),
            'size' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            'floor' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['available', 'occupied', 'maintenance']),
        ];
    }
}
