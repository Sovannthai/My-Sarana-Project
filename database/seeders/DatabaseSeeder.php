<?php

namespace Database\Seeders;

use App\Models\MonthlyUsage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoomSeeder::class);
        $this->call(AmenitySeeder::class);
        $this->call(RoomPricingSeeder::class);
        $this->call(UtilityRateSeeder::class);
        $this->call(PriceAdjustmentSeeder::class);
        $this->call(MonthlyUsageSeeder::class);
    }
}
