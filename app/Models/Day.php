<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $hidden = ['pivot'];

    public function classes(){
        //One day may have many classes, 'class_days' is the pivot table.
        return $this->belongsToMany(StudentClass::class, 'class_days');
    }
}