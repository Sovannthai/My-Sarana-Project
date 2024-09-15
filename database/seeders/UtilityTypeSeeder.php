<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UtilityType;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;

class UtilityTypeSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate('utility_types');

        $utilityTypes = ['Electricity', 'Water', 'Gas'];

        foreach ($utilityTypes as $type) {
            UtilityType::firstOrCreate(['type' => $type]);
        }

        $this->enableForeignKeys();
    }
}
