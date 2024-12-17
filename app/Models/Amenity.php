<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'additional_price'];


    /**
     * Get the rooms that have the amenity.
     */
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'room_amenity');
    }
    public function paymentamenity()
    {
        return $this->hasMany(PaymentAmenity::class);
    }
}
