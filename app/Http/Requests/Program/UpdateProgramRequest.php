<?php

namespace App\Http\Requests\Program;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateProgramRequest extends FormRequest
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
            'manager_id' => [
                'nullable',
                'uuid',
                Rule::exists('users', 'id'),
            ],
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'number_semesters' => [
                'required',
                'integer',
                'min:1',
                'max:15',
            ],
            'number_credits' => [
                'required',
                'integer',
                'min:1',
                'max:500',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $managerId = $this->input('manager_id');

                if ($managerId && !$validator->errors()->has('manager_id')) {
                    $user = User::find($managerId);

                    if ($user && !$user->hasRole('MANAGER')) {
                        $validator->errors()->add(
                            'manager_id',
                            'El usuario seleccionado no tiene los permisos requeridos (Manager) para ser asignado como Manager de Programa.'
                        );
                    }
                }
            }
        ];
    }

    public function messages(): array
    {
        return [
            'manager_id.uuid' => 'El ID del Manager debe ser un formato UUID válido.',
            'manager_id.exists' => 'El Manager (Usuario) seleccionado no existe.',

            'name.required' => 'El nombre del programa es obligatorio.',
            'name.string' => 'El nombre del programa debe ser texto.',
            'name.max' => 'El nombre del programa no debe exceder los :max caracteres.',

            'description.string' => 'La descripción debe ser texto.',
            'description.max' => 'La descripción no debe exceder los :max caracteres.',

            'number_semesters.required' => 'El número de semestres es obligatorio.',
            'number_semesters.integer' => 'El número de semestres debe ser un número entero.',
            'number_semesters.min' => 'El programa debe tener al menos :min semestre.',
            'number_semesters.max' => 'El número de semestres no debe exceder los :max.',

            'number_credits.required' => 'El número de créditos es obligatorio.',
            'number_credits.integer' => 'El número de créditos debe ser un número entero.',
            'number_credits.min' => 'El programa debe tener al menos :min crédito.',
            'number_credits.max' => 'El número de créditos no debe exceder los :max.',
        ];
    }
}
