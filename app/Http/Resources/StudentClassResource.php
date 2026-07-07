<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'student_id' => $this->student->id,
            'student'    => $this->student->name,
            'color'      => $this->student->color->name,
            'starts'     => $this->starts->format('H:i'),
            'ends'       => $this->ends->format('H:i'),
            'class_notes'      => $this->student->class_notes,
            'class_notes_date' => $this->student->class_notes_date,

            //days return multiple days, 
            //with map we can convert them to an array of arrays.
            'days' => $this->days->map->only(['id', 'name']),
        ];
    }
}
