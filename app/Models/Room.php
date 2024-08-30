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
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'room_amenity');
    }

    /**
     * Get the pricing records associated with the room.
     */
    public function roomPricings()
    {
        return $this->hasMany(RoomPricing::class);
    }
}
