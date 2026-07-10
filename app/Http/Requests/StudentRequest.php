<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        //List of fields that are going to be sanitized.
        $this->merge($this->sanitize($this->only([
                                                    'name',
                                                    'birthdate',
                                                    'phone',
                                                    'email',
                                                    'class_notes',
                                                    'progress',
                                                    'color_id',
                                                    'level_id',
                                                ])));
    }

    //Clean empty spaces from strings.
    public function sanitize(array $data): array
    {
        //Collect wraps data and gives usefull methods 
        //like map wich is used to loop data and transform each value
        return collect($data)->map(function ($value){
            //Delete empty spaces.
            if(is_string($value)){
                $value = trim($value);
                $value = trim($value, '"');
                return $value === '' ? null : $value;
            }

            return $value;
        })->toArray();//Convert to array again
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //Get student id from url.
        $studentId = $this->route('student');

        //email:rfc,dns = Standard email checks basic formatting. 
        //Adding :rfc,dns uses RFC compliance logic and performs 
        //a quick DNS lookup to verify the email domain actually exists.
        return [
            'name'        => 'required|string|max:255',
            'birthdate'   => 'nullable|date',
            'phone'       => 'nullable|string|max:50',
            'class_notes' => 'nullable|string|max:2000',
            'progress'    => 'nullable|string|max:2000',
            'color_id'    => 'required|integer|exists:colors,id',
            'level_id'    => 'required|integer|exists:levels,id',
            'email'       => [  'nullable',
                                'string',
                                'max:70',
                                'email:rfc,dns',
                                Rule::unique('students', 'email')->ignore($studentId)],
        ];
    }

    public function messages(): array
    {
        return ['name.required' => 'Name is required.'];
    }
}
