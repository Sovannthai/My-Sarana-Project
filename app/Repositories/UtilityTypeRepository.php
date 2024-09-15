<?php

namespace App\Repositories;

use App\Models\UtilityType;

class UtilityTypeRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new UtilityType());
    }
}
