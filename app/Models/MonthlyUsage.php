<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'utility_type_id',
        'month',
        'year',
        'usage',
    ];

    public function room()
{
    return $this->belongsTo(Room::class);
}

public function utilityType()
{
    return $this->belongsTo(UtilityType::class, 'utility_type_id');
}

}
