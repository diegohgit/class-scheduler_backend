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
        //Add ?? '' to nullable fields so isDirty can work in React.
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name ?? '',
            'phone'      => $this->phone     ?? '',
            'email'      => $this->email     ?? '',
            'progress'   => $this->progress  ?? '',
            'birthdate'  => $this->birthdate?->format('m/d/Y') ?? '',
            'class_notes'      => $this->class_notes ?? '',
            'class_notes_date' => $this->class_notes_date?->format('m/d/Y'),

            'level' => ['id'   => $this->level->id,
                        'name' => $this->level->name,],

            'color' => ['id'   => $this->color->id,
                        'name' => $this->color->name,],
        ];
    }
}