<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function wantsJson()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // ✅ Convierte el campo email a minúsculas antes de validar.
        $this->merge([
            'email' => Str::lower($this->input('email')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_number' => ['required', 'numeric', 'unique:users,id_number'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'unique:users,email'
            ],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'password' => [
                'required', 
                'string', 
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [

            'password.regex' => 'La contrasena debe contener al menos 8 caracteres, una mayuscula, una minuscula, un numero y un simbolo.',
            'password.min' => 'La contrasena debe contener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmacion del campo de contrasena no coincide.',

            'first_name.required' => 'El nombre es requerido.',
            'first_name.string' => 'El nombre debe ser una cadena de texto valida.',
            'first_name.max' => 'El nombre es demasiado largo (maximo 100 caracteres).',

            'last_name.required' => 'El apellido es requerido.',
            'last_name.string' => 'El apellido debe ser una cadena de texto valida.',
            'last_name.max' => 'El apellidoe es demasiado largo (maximo 100 caracteres).',

            'email.required' => 'El correo electronico es requerido.',
            'email.unique' => 'Este correo electronico ya esta registrado.',
            'email.string' => 'El correo electronico debe ser una cadena de texto valida.',
            'email.email' => 'El correo electranico no cuenta con el formato correspondiente (user@email.com).',
            
            'id_number.required' => 'El numero de identificacion es requerido',
            'id_number.numeric' => 'El numero de identificacion debe ser un numero',
            'id_number.unique' => 'El numero de identificacion ya esta registrado.',
        ];
    }
}
