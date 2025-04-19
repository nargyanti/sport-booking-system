<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourtBooking extends Model
{
    protected $fillable = [
        'schedule_id',
        'court_name',
        'start_time',
        'end_time',
        'cost',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
