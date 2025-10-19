<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Role\RoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    protected $user;

    public function __construct($user)
    {
        parent::__construct($user);

        $this->user = $user;
    }

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
            'roles' => RoleResource::collection($this->user->roles),
        ];
    }
}
