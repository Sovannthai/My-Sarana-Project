<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\UtilityType;
use App\Models\MonthlyUsage;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyUsageFactory extends Factory
{
    protected $model = MonthlyUsage::class;

    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'utility_type_id' => UtilityType::factory(),
            'month' => $this->faker->numberBetween(1, 12),
            'year' => $this->faker->year,
            'usage' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
