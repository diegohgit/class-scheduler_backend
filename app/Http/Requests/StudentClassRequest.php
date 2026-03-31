<?php 
namespace App\Http\Requests;

use App\Models\StudentClass;
use Illuminate\Foundation\Http\FormRequest;

class StudentClassRequest extends FormRequest{
    //Every FormRequest needs an authorize method.
    public function authorize(){return true;}

    public function rules(){
        return [
            'student_id' => 'required|integer|gt:0',
            'day_id'     => 'required|integer|gt:0|max:7',
            'starts'     => 'required|date_format:H:i',
            'ends'       => 'required|date_format:H:i',
        ];
    }

    public function withValidator($validator){
        //If the rules validation fails, stop execution.
        if($validator->fails()) return;

        //This callback will be executed after the rules validation.
        $validator->after(function($v){

            $id = $this->route('id');

            $v = StudentClass::validateNoOverlap(
                $this->day_id,
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