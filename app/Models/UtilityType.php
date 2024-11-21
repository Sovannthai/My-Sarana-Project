<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityType extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'unit_price'];

    public function utilityrates()
    {
        return $this->hasMany(UtilityRate::class, 'utility_type_id');
    }

    public function monthlyUsages()
    {
        return $this->hasMany(MonthlyUsage::class);
    }
}
