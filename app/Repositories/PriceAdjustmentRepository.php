<?php

namespace App\Repositories;

use App\Models\PriceAdjustment;

class PriceAdjustmentRepository extends BaseRepository
{
    /**
     * RoomPricingRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(new PriceAdjustment());
    }
}
