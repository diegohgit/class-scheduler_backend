<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //Show detailed information about a student.
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'birthdate' => $this->birthdate?->format('m/d/Y'),
            'progress'  => $this->progress,
            'class_notes'      => $this->class_notes,
            'class_notes_date' => $this->class_notes_date?->format('m/d/Y'),

            'level' => ['id'   => $this->level->id,
                        'name' => $this->level->name,],

            'color' => ['id'   => $this->color->id,
                        'name' => $this->color->name,],
        ];
    }
}