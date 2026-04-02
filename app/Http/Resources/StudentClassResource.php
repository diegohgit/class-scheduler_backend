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
            'day_id'     => $this->day_id,
            'starts'     => $this->starts->format('H:i'),
            'ends'       => $this->ends->format('H:i'),
        ];
    }
}
