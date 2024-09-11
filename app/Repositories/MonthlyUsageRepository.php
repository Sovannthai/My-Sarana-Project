<?php

namespace App\Repositories;

use App\Models\MonthlyUsage;

class MonthlyUsageRepository extends BaseRepository
{
    /**
     * RoomPricingRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(new MonthlyUsage());
    }
}
