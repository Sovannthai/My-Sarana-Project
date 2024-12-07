<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyUsage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function utilityTypes()
    {
        return $this->belongsToMany(UtilityType::class, 'monthly_usage_details')
            ->withPivot('usage')
            ->withTimestamps();
    }

    public function monthlyUsageDetails()
    {
        return $this->hasMany(MonthlyUsageDetail::class);
    }

    public function details()
    {
        return $this->hasMany(MonthlyUsageDetail::class);
    }
}
