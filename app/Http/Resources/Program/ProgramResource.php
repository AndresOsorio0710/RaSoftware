<?php

namespace App\Http\Resources\Program;

use App\Http\Resources\Faculty\FacultyResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'reference' => $this->reference,
            'type_program' => $this->type_program,
            'number_semesters' => $this->number_semesters,
            'number_credits' => $this->number_credits,
            'description' => $this->description,
            'faculty' => FacultyResource::make($this->whenLoaded('faculty')),
            'manager' => UserResource::make($this->whenLoaded('manager')),
        ];
    }
}
