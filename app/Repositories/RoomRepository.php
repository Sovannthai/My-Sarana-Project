<?php

namespace App\Repositories;

use App\Models\Room;

class RoomRepository extends BaseRepository
{
    /**
     * RoomRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(new Room());
    }
}
