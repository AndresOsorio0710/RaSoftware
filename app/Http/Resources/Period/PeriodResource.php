<?php

namespace App\Http\Resources\Period;

use App\Http\Resources\Program\ProgramResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeriodResource extends JsonResource
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
            'reference' => $this->reference,
            'name' => $this->name,
            'period_number' => $this->period_number,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'program' => ProgramResource::make($this->whenLoaded('program')),
        ];
    }
}
