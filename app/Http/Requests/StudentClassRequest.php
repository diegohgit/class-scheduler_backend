<?php 
namespace App\Http\Requests;

use App\Models\StudentClass;
use Illuminate\Foundation\Http\FormRequest;

class StudentClassRequest extends FormRequest{
    //Every FormRequest needs an authorize method.
    public function authorize(){return true;}

    public function rules(){
        return [
            'id'          => 'nullable|integer|gt:0',
            'student_id'  => 'required|integer|gt:0',
            'days_ids'    => 'required|array',
            'starts'      => 'required|date_format:H:i',
            'ends'        => 'required|date_format:H:i',
            'class_notes' => 'string',
        ];
    }

    public function withValidator($validator){
        //If the rules validation fails, stop execution.
        if($validator->fails()) return;

        //This callback will be executed after the rules validation.
        $validator->after(function($v){

            $id = $this->route('student_class');

            $v = StudentClass::validateNoOverlap(
                    $this->days_ids,
                    $this->starts,
                    $this->ends,
                    $id
            );

            if(!$v){
                $v->errors()->add('overlap', $v);
            }
        });
    }
}
?>