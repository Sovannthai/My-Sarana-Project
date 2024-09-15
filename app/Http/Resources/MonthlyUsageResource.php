<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonthlyUsageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room_id' => $this->room_id,
            'utility_type_id' => $this->utility_type_id,
            'month' => $this->month,
            'year' => $this->year,
            'usage' => $this->usage,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
