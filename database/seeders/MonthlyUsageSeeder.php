<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\MonthlyUsage;
use App\Models\UtilityType;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;

class MonthlyUsageSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    public function run(): void
    {
        $this->disableForeignKeys();

        $this->truncate('monthly_usages');

        $rooms = Room::all();
        $utilityTypes = UtilityType::all();

        foreach ($rooms as $room) {
            foreach ($utilityTypes as $utilityType) {
                MonthlyUsage::factory()->create([
                    'room_id' => $room->id,
                    'utility_type_id' => $utilityType->id,
                ]);
            }
        }

        $this->enableForeignKeys();
    }
}
