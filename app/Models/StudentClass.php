<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentClass extends Model
{

    protected $fillable = [ 'student_id',
                            'day_id',
                            'starts',
                            'ends'
                            ];

    //Add format H:i to time data because it returns 00:00:00 by default.
    protected $casts = [
        'starts' => 'datetime:H:i',
        'ends'   => 'datetime:H:i',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public static function validateNoOverlap($dayId, $start, $end, $ignoreId = null)
    {

        //Search for a class with same day and 
        //a time wich overlaps with the new class.
        $query = DB::table('student_classes')
                    ->where('day_id', $dayId)
                    ->where(function($q) use ($start, $end){
                        $q->where('starts', '<', $end)
                          ->where('ends',   '>', $start);  
                    });

        //In case a class is going to be updated
        //ignore id of the class.
        if($ignoreId){
            $query->where('id', '!=', $ignoreId);
        }

        //Return a message if an overlaped class is found
        if($query->exists()){
            throw ValidationException::withMessages([
                'schedule' => 'This time range overlaps with an existing class.',
            ]);
        }else{
            return true;
        }
    }
}
