<?php

namespace App\Models;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Section extends Model
{
    protected $fillable = ['name', 'chapter_id'];

    public function chapters(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}