<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UtilityRateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'rateperunit' => $this->rateperunit,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
