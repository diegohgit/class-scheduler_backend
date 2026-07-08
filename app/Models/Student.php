<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [ 'name',
                            'birthdate',
                            'phone',
                            'class_notes',
                            'class_notes_date',
                            'progress',
                            'color_id',
                            'level_id',
                            'is_active',
                        ];

    //Use $casts to convert database values into specific types
    protected $casts =[
        //Convert some fields to date (it comes from DB as String)
        //so we can give a date format (the format is defined in StudentResource)
        'birthdate' => 'date',
        'class_notes_date' => 'date',
    ];

    //This function validates class_notes before store it.
    //If class_notes is null stores, class_notes_date as null too.
    //if class_notes has content, stores class_notes_date as today().
    protected static function booted(){
        static::saving(function ($student){

            if(blank($student->class_notes)){
                $student->class_notes      = null;
                $student->class_notes_date = null;

            }else{
                $student->class_notes_date = today();
            }
        });
    }

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

    public function studentClass(): HasMany
    {
        return $this->hasMany(StudentClass::class);
    }

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class);
    }
}