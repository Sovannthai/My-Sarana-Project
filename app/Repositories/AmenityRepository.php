<?php

namespace App\Repositories;

use App\Models\Amenity;

class AmenityRepository extends BaseRepository
{
    /**
     * AmenityRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(new Amenity());
    }
}
