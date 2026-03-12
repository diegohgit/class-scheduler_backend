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
            ];
        }

        //the other case is students.show and it need more information
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'birthdate' => $this->birthdate?->format('m/d/Y'),
            'homework'  => $this->homework,
            'progress'  => $this->progress,
            'level' => $this->level->id,
            'color' => (string) $this->color->id
        ];
    }
}
