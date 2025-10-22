<?php

namespace App\Application\Handlers\Program\CreateProgram;

use App\Core\ApiResponse;
use App\Http\Resources\Program\ProgramResource;
use App\Models\Program;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreateProgramHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Maneja la lógica de creación de un nuevo programa.
     *
     * @param array $data Los datos validados del programa.
     * @return JsonResponse
     */
    public function handler(array $data): JsonResponse
    {
        try {
            $program = Program::create($data);

            $program->refresh()->load(['faculty', 'manager']);

            $response = new ProgramResource($program);

            Log::info('Programa creado exitosamente.', [
                'program_id' => $program->id,
                'name' => $program->name
            ]);

            return ApiResponse::created(
                $response,
                "Programa creado exitosamente"
            );
        } catch (QueryException $ex) {
            Log::error('Error de base de datos al intentar crear un programa.', [
                'exception' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al intentar crear el programa.");
        } catch (Exception $e) {
            Log::error('Error inesperado al crear el programa.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $data,
            ]);

            return ApiResponse::internalServerError("Error inesperado al crear el programa.");
        }
    }
}
