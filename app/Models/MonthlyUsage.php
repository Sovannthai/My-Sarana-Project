<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyUsage extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'month', 'year', 'waterusage', 'electricityusage'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
