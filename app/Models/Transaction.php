<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'transaction_date',
        'amount',
        'note',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeExpenses($query)
    {
        return $query->whereHas('category', function ($query) {
            $query->where('is_expense', true);
        });
    }

    public function scopeIncomes($query)
    {
        return $query->whereHas('category', function ($query) {
            $query->where('is_expense', false);
        });
    }
}
