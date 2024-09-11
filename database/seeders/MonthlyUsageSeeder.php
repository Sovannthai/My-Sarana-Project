<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\MonthlyUsage;
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

        foreach ($rooms as $room) {
            MonthlyUsage::factory()->create([
                'room_id' => $room->id,
            ]);
        }

        $this->enableForeignKeys();
    }
}
