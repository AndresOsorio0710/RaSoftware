<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $firstName = $this->first_name ?? '';
        $lastName = $this->last_name ?? '';

        return [
            'id' => $this->id,
            'id_number' => $this->id_number,
            'user_name' => $this->user_name,
            'email' => $this->email,
            'first_name' => strtoupper($firstName),
            'last_name' => strtoupper($lastName),
        ];
    }
}
