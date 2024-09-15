<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAdjustment extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'amount', 'reason', 'startdate', 'enddate'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
