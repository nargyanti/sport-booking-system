<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'component_type_id',
        'amount',
        'is_custom',
        'custom_amount',
        'is_paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function componentType()
    {
        return $this->belongsTo(BillComponent::class, 'component_type_id');
    }
}
