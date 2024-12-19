<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseTransaction extends Model
{
    use HasFactory;

    protected $table = 'expense_transactions';
    protected $fillable = ['category_id', 'amount', 'note', 'date'];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
}
