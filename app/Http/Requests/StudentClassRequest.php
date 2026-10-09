<?php 
namespace App\Http\Requests;

use App\Models\ActiveHour;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StudentClassRequest extends FormRequest{
    //Every FormRequest needs an authorize method.
    public function authorize(){return true;}

    public function rules(){
        return [
            'id'          => 'nullable|integer|exists:student_classes,id',
            'student_id'  => 'required|integer|exists:students,id',
            'days_ids'    => 'required|array',
            'starts'      => 'required|date_format:H:i:s',
            'ends'        => 'required|date_format:H:i:s|after:starts',
            'class_notes' => 'nullable|string',
            'delete_id'   => 'nullable|integer|exists:student_classes,id',
        ];
    }

    public function withValidator($validator){
        //If the rules validation fails, stop execution.
        if($validator->fails()) return;

        //This callback will be executed after the rules validation.
        $validator->after(function($v){

            //Validate class duration
            $start = Carbon::createFromFormat('H:i:s', $this->starts);
            $end   = Carbon::createFromFormat('H:i:s', $this->ends);

            //If class ends at midnight, add a day to take the
            //midnight of the following day.
            if($this->ends === '00:00:00') $end->addDay();

            if($start->diffInMinutes($end) > 180
               || $start->diffInMinutes($end) < 15) 
            {
                $v->errors()->add(
                    'duration',
                    'The class cannot last more than 3 hours or less than 15 minutes.'
                );
            }



            //Validate that the selected time range is inside the ActiveHours range.
            $activeHours = ActiveHour::find(1);

            if($activeHours){
                $until = Carbon::createFromFormat('H:i:s', $activeHours->until);
                $from  = Carbon::createFromFormat('H:i:s', $activeHours->from);

                //If class $activeHours->until = midnight, add a day to take the
                //midnight of the following day.
                if($activeHours->until === '00:00:00') $until->addDay();

                if( $start->lt($from) || $end->gt($until))
                {
                    $v->errors()->add(
                        'inside',
                        'This time range is outside the active hours.'
                    );
                }
            }



            //Validate no overlap
            $id = $this->route('student_class');

            $overlapResult = StudentClass::validateNoOverlap(
                                $this->days_ids,
                                $this->starts,
                                $this->ends,
                                $id
                            );

            if(!$overlapResult){
                $v->errors()->add('overlap', $v);
            }
        });
    }
}
?>