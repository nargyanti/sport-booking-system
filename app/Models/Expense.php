<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'schedule_id',
        'category_id',
        'description',
        'amount',
        'paid_by',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
