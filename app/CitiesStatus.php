<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitiesStatus extends Model
{
    protected $fillable = [
        'change_cities',
        'is_active',
    ];
}
