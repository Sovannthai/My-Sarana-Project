<?php

namespace App\Repositories;

use App\Models\MonthlyUsage;

class MonthlyUsageRepository extends BaseRepository
{
    /**
     * MonthlyUsageRepository constructor.
     *
     * @param MonthlyUsage $model
     */
    public function __construct(MonthlyUsage $model)
    {
        parent::__construct($model);
    }

    /**
     * Get monthly usage for a specific room and utility type.
     *
     * @param int $roomId
     * @param int $utilityTypeId
     * @param int $month
     * @param int $year
     * @return MonthlyUsage|null
     */
    public function getByRoomUtilityAndDate(int $roomId, int $utilityTypeId, int $month, int $year): ?MonthlyUsage
    {
        return $this->model->where('room_id', $roomId)
                           ->where('utility_type_id', $utilityTypeId)
                           ->where('month', $month)
                           ->where('year', $year)
                           ->first();
    }
}
