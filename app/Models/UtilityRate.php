<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityRate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function utilityType()
    {
        return $this->belongsTo(UtilityType::class, 'utility_type_id');
    }
}
