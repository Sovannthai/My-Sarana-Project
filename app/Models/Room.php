<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'description',
        'size',
        'floor',
        'status',
    ];

    /**
     * Get the amenities associated with the room.
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenity', 'room_id', 'amenity_id');
    }


    /**
     * Get the pricing records associated with the room.
     */
    public function roomPricing()
    {
        return $this->hasMany(RoomPricing::class);
    }

    /**
     * Get the adjustment records associated with the room.
     */
    public function roomAdjustment()
    {
        return $this->hasMany(RoomPricing::class);
    }

    public function monthlyUsages()
    {
        return $this->hasMany(MonthlyUsage::class);
    }

    public function userContracts()
    {
        return $this->hasMany(UserContract::class);
    }
}
