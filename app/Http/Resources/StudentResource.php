<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //Return only necessary information to show in a table or list
        if($request->routeIs('students.index')){
            return [
                'id'    => $this->id,
                'name'  => $this->name,
                'level' => $this->level->name,
                'class_notes'      => $this->class_notes,
                'class_notes_date' => $this->class_notes_date,
            ];
        }

        //the other case is students.show and it need more information
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'birthdate' => $this->birthdate?->format('m/d/Y'),
            'progress'  => $this->progress,
            'class_notes'      => $this->class_notes,
            'class_notes_date' => $this->class_notes_date?->format('m/d/Y'),

            'level' => ['id' => $this->level->id,
                        'name' => $this->level->name,],

            'color' => ['id' => $this->color->id,
                        'name' => $this->color->name,],
        ];
    }
}