<?php

namespace App\Application\Handlers\Program\ListProgram;

use App\Core\ApiResponse;
use App\Http\Resources\Program\ProgramResource;
use App\Models\Program;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ListProgramByFacultyIdHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Maneja la lógica para obtener todos los programas asociados a un Faculty ID.
     *
     * @param string $facultyId El UUID de la facultad.
     * @return JsonResponse
     */
    public function handler(string $facultyId): JsonResponse
    {
        if (!Str::isUuid($facultyId)) {
            Log::info("El formato del identificador de facultad proporcionado ($facultyId) no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador de facultad no es un UUID válido.");
        }

        try {
            $programs = Program::with(['faculty', 'manager'])
                ->where('faculty_id', $facultyId)
                ->orderBy('name', 'asc')
                ->get();

            if ($programs->count() === 0) {
                Log::info(
                    'No se tienen programas registrados en la facultad indicada.',
                    ['faculty_id' => $facultyId],
                );
                return ApiResponse::errorNotFound('No se tienen programas registrados en la facultad indicada.');
            }

            $response = ProgramResource::collection($programs)->toResponse(request())->getData();

            Log::info("Programas consultados con éxito para la Facultad ID:$facultyId. Resultados: " . $programs->count());

            return ApiResponse::success(
                $response,
                "Programas de la facultad obtenidos con éxito."
            );
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar programas por facultad.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
                ['faculty_id' => $facultyId],
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar programas por facultad.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al recuperar programas.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
                ['faculty_id' => $facultyId],
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al recuperar programas.");
        }
    }
}
