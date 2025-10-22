<?php

namespace App\Http\Requests\Program;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CreateProgramRequest extends FormRequest
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
            'faculty_id' => [
                'required',
                'uuid',
                Rule::exists('faculties', 'id'),
            ],
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
            'reference' => [
                'required',
                'string',
                'max:50',
                Rule::unique('programs', 'reference'),
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'type_program' => [
                'required',
                'string',
                Rule::in(['PREGRADO', 'POSTGRADO']),
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

                // Solo si se proporcionó un manager_id válido y la verificación de UUID/Exists pasó
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
            'faculty_id.required' => 'El campo ID de Facultad es obligatorio.',
            'faculty_id.uuid' => 'El ID de Facultad debe ser un formato UUID válido.',
            'faculty_id.exists' => 'La Facultad seleccionada no existe.',

            'manager_id.uuid' => 'El ID del Manager debe ser un formato UUID válido.',
            'manager_id.exists' => 'El Manager (Usuario) seleccionado no existe.',

            'name.required' => 'El nombre del programa es obligatorio.',
            'name.string' => 'El nombre del programa debe ser texto.',
            'name.max' => 'El nombre del programa no debe exceder los :max caracteres.',

            'reference.required' => 'La referencia o código del programa es obligatorio.',
            'reference.string' => 'La referencia debe ser texto.',
            'reference.max' => 'La referencia no debe exceder los :max caracteres.',
            'reference.unique' => 'Ya existe un programa con esta referencia o código.',

            'description.string' => 'La descripción debe ser texto.',
            'description.max' => 'La descripción no debe exceder los :max caracteres.',

            'type_program.required' => 'El tipo de programa es obligatorio.',
            'type_program.string' => 'El tipo de programa debe ser texto.',
            'type_program.in' => 'El tipo de programa debe ser PREGRADO o POSTGRADO.',

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
