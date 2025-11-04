<?php

namespace App\Http\Requests\Period;

use App\Models\Program;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'period_number' => [
                'required',
                'integer',
                'min:1',
                'max:15',
                function ($attribute, $value, $fail) {
                    $programId = $this->input('program_id');
                    if ($programId) {
                        $program = Program::find($programId);
                        if ($program && $value > $program->number_semesters) {
                            $fail("El número de período ($value) no puede exceder los {$program->number_semesters} semestres definidos para el programa.");
                        }
                    }
                },
            ],

            'start_at' => [
                'required',
                'date_format:Y-m-d',
            ],

            'end_at' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:start_at',
                'after_or_equal:today',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del período es obligatorio.',
            'name.string' => 'El nombre del período debe ser texto.',
            'name.max' => 'El nombre del período no debe exceder los :max caracteres.',

            'period_number.required' => 'El número de período es obligatorio.',
            'period_number.integer' => 'El número de período debe ser un número entero.',
            'period_number.min' => 'El número de período no puede ser menor a :min.',
            'period_number.max' => 'El número de período no puede ser mayor a :max.',

            'start_at.required' => 'La fecha de inicio es obligatoria.',

            'end_at.required' => 'La fecha de fin es obligatoria.',
            'end_at.after_or_equal' => 'La fecha de fin no puede ser anterior a la fecha de inicio.',
            'end_at.after_or_equal' => 'La fecha de fin no puede ser anterior a la fecha de inicio ni a la fecha actual.',
        ];
    }
}
