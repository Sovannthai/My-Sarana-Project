<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;

class AmenitySeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate('amenities');
        $amenity = Amenity::factory(10)->create();
        $this->enableForeignKeys();
    }
}
