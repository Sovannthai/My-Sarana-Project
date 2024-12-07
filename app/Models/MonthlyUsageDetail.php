<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyUsageDetail extends Model
{
    public function utilityType()
    {
        return $this->belongsTo(UtilityType::class);
    }
}
