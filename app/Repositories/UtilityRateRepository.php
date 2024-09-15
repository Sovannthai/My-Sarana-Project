<?php

namespace App\Repositories;

use App\Models\UtilityRate;

class UtilityRateRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new UtilityRate());
    }
}
