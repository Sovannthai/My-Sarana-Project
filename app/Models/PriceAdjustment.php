<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAdjustment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the room that owns the price adjustment.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
