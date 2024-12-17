<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentUtility extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }
    public function utility()
    {
        return $this->belongsTo(UtilityType::class,'utility_id');
    }
}
