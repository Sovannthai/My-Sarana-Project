<?php

namespace Database\Factories;

use App\Models\MonthlyUsage;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyUsageFactory extends Factory
{
    protected $model = MonthlyUsage::class;

    public function definition()
    {
        return [
            'room_id' => \App\Models\Room::factory(),
            'month' => $this->faker->month,
            'year' => $this->faker->year,
            'waterusage' => $this->faker->randomFloat(2, 0, 100),
            'electricityusage' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
