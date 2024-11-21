<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'percentage',
        'description',
        'status',
        'type',
        'min_months',
        'start_date',
        'end_date',
        'min_prepayment_months'
    ];

    /**
     * Get the room that owns the price adjustment.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
