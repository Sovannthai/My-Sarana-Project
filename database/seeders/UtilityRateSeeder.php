<?php

namespace Database\Seeders;

use App\Models\UtilityRate;
use App\Models\UtilityType;
use Illuminate\Database\Seeder;
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

        $utilityTypes = UtilityType::all();

        foreach ($utilityTypes as $utilityType) {
            UtilityRate::factory(3)->create([
                'utility_type_id' => $utilityType->id,
            ]);
        }

        $this->enableForeignKeys();
    }
}
