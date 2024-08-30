<?php

namespace App\Repositories;

use App\Models\RoomPricing;

class RoomPricingRepository extends BaseRepository
{
    /**
     * RoomPricingRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(new RoomPricing());
    }
}
