<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'location',
    ];

    // Relasi
    public function courtBookings()
    {
        return $this->hasMany(CourtBooking::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function subsidies()
    {
        return $this->hasMany(Subsidy::class);
    }
}
