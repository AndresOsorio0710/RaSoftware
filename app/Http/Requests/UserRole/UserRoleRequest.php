<?php

namespace App\Http\Requests\UserRole;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'uuid',
                'exists:users,id'
            ],
            'role_id' => [
                'required',
                'uuid',
                'exists:roles,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'El ID del usuario es obligatorio para la asignación.',
            'user_id.uuid'     => 'El ID del usuario debe ser un formato UUID válido.',
            'user_id.exists'   => 'El usuario con el ID proporcionado no existe.',

            'role_id.required' => 'El ID del rol es obligatorio para la asignación.',
            'role_id.uuid'     => 'El ID del rol debe ser un formato UUID válido.',
            'role_id.exists'   => 'El rol con el ID proporcionado no existe.',
        ];
    }
}
