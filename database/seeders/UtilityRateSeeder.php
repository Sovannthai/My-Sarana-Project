<?php

namespace Database\Seeders;

use App\Models\UtilityRate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;

class UtilityRateSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate('utility_rates');
        $room = UtilityRate::factory(3)->create();
        $this->enableForeignKeys();
    }
}
