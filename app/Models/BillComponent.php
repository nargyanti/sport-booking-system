<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillComponent extends Model
{
    protected $fillable = ['name', 'code', 'is_active'];
}
