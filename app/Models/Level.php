<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    public $timestamps = false;

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
