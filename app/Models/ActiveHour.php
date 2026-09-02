<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveHour extends Model
{
    
    protected $fillable = ['from', 'until'];

    public $timestamps = false;

    //Add format H:i to time data because it returns 00:00:00 by default.
    protected $casts = [
        'from'  => 'datetime:H:i',
        'until' => 'datetime:H:i',
    ];
}