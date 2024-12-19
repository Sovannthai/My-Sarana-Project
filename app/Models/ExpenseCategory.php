<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ExpenseCategoryFactory> */
    use HasFactory;

    protected $table = 'expense_categories';
    protected $fillable = ['title', 'icon'];

    public function transactions()
    {
        return $this->hasMany(ExpenseTransaction::class, 'category_id');
    }
}
