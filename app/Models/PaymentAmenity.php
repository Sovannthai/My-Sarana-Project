<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAmenity extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }
    public function amenity()
    {
        return $this->belongsTo(Amenity::class,'amenity_id');
    }
}
