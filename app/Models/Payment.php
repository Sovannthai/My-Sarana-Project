<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function userContract()
    {
        return $this->belongsTo(UserContract::class);
    }
    public function paymentamenities()
    {
        return $this->hasMany(PaymentAmenity::class,'payment_id');
    }
    public function paymentutilities()
    {
        return $this->hasMany(PaymentUtility::class,'payment_id');
    }

}
