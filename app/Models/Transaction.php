<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'paid_by_user_id',
        'schedule_id',
        'total_paid',
        'image',
        'status_id',
        'notes',
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by_user_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function status()
    {
        return $this->belongsTo(TransactionStatus::class, 'status_id');
    }

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'transaction_bill');
    }

    public function recipients()
    {
        return $this->belongsToMany(User::class, 'transaction_recipients');
    }
}
