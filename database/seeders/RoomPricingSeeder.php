<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomPricing;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;

class RoomPricingSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        // Truncate the room_pricings table instead of rooms
        $this->truncate('room_pricings');

        // Ensure there are rooms to associate pricing with
        $rooms = Room::all();

        // Create RoomPricing records for each Room
        foreach ($rooms as $room) {
            RoomPricing::factory()->create([
                'room_id' => $room->id,
            ]);
        }

        $this->enableForeignKeys();
    }
}
