<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'base_price',
        'effective_date',
    ];

    /**
     * Get the room associated with the pricing.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
