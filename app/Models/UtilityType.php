<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function utilityrates()
    {
        return $this->hasMany(UtilityRate::class, 'utility_type_id');
    }

    public function monthlyUsages()
    {
        return $this->belongsToMany(MonthlyUsage::class, 'monthly_usage_details')
            ->withPivot('usage')
            ->withTimestamps();
    }

    public function activeRate()
    {
        return $this->rates()->where('status', '1')->first();
    }
    public function paymentutility()
    {
        return $this->hasMany(PaymentUtility::class);
    }

}
