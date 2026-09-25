<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    //Hide extra information about table relations to have a cleaner response.
    protected $hidden = ['pivot'];

    public $timestamps = false;

    public function classes(){
        //One day may have many classes, 'class_days' is the pivot table.
        return $this->belongsToMany(StudentClass::class, 'class_days');
    }
}