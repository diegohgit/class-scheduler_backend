<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //Return only necessary information to show in a table or list.
        return [
            'id'          => $this->id,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'level'       => $this->level->name,
            'class_notes' => $this->class_notes,
            'class_notes_date' => $this->class_notes_date?->format('m/d/Y'),
        ];
    }
}
