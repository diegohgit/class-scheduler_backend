<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
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
}