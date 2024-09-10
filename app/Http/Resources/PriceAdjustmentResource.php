<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceAdjustmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room_id' => $this->room_id,
            'amount' => $this->amount,
            'reason' => $this->reason,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
