<?php

namespace App\Models;

use App\Models\Day;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentClass extends Model
{
    protected $fillable = [ 'student_id',
                            'starts',
                            'ends',];



    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }



    public function days(){
        //One class may have many days, 'class_days' is the pivot table.
        return $this->belongsToMany(Day::class, 'class_days');
    }



    public static function validateNoOverlap($dayIds, $start, $end, $ignoreId = null)
    {
        //Search for a class with same day and
        //a time wich overlaps with the new class.
        $query = DB::table('student_classes as sc')
                    ->join('class_days as cd', 'cd.student_class_id', '=', 'sc.id')
                    ->whereIn('cd.day_id', $dayIds)
                    ->where(function($q) use ($start, $end){
                        $q->where('sc.starts', '<', $end)
                          ->where('sc.ends',   '>', $start);
                    });

        //In case a class is going to be updated
        //ignore id of the class.
        if($ignoreId){
            $query->where('sc.id', '!=', $ignoreId);
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