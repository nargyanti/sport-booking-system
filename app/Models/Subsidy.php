<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsidy extends Model
{

    protected $fillable = [
        'schedule_id',
        'component_type_id',
        'amount',
        'paid_by_user_id',
        'note',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function componentType()
    {
        return $this->belongsTo(BillComponent::class, 'component_type_id');
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by_user_id');
    }
}
