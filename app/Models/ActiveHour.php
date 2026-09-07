<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveHour extends Model
{

    protected $fillable = ['from', 'until'];

    public $timestamps = false;
}