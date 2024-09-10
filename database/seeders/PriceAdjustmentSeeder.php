<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\PriceAdjustment;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;

class PriceAdjustmentSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        // Truncate the room_pricings table instead of rooms
        $this->truncate('price_adjustments');

        // Ensure there are rooms to associate pricing with
        $rooms = Room::all();

        // Create RoomPricing records for each Room
        foreach ($rooms as $room) {
            PriceAdjustment::factory()->create([
                'room_id' => $room->id,
            ]);
        }

        $this->enableForeignKeys();
    }
}
