<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonthlyUsageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room_id' => $this->room_id,
            'month' => $this->month,
            'year' => $this->year,
            'waterusage' => $this->waterusage,
            'electricityusage' => $this->electricityusage,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
