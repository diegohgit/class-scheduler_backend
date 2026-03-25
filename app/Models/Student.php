<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    //Use $casts to convert database values into specific types
    protected $casts =[
        //in this case we convert birthdate to date (it comes from DB as String)
        //and now we can give a format (the format is defined in StudentResource)
        'birthdate' => 'date',
    ];

    //This is to enforce eager loading
    protected $with = ['level', 'color'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function scopeSearchByName($query, $name){
        return $query->where('name', 'LIKE', "%{$name}%");
    }
}