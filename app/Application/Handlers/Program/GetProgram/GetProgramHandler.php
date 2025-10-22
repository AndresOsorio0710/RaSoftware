<?php

namespace App\Application\Handlers\Program\GetProgram;

use App\Core\ApiResponse;
use App\Http\Resources\Program\ProgramResource;
use App\Models\Program;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GetProgramHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(string $id): JsonResponse
    {
        if (!Str::isUuid($id)) {
            Log::info("El formato del identificador proporcionado ($id) no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador no es un UUID válido.");
        }

        try {
            $program = Program::with(['faculty', 'manager'])->findOrFail($id);

            $response = new ProgramResource($program);

            Log::info("Programa con ID:$id, encontrado.", ['id' => $id]);

            return ApiResponse::success(
                $response,
                "Programa encontrado."
            );
        } catch (ModelNotFoundException $e) {
            Log::info("Programa con ID:$id, no encontrado.", ['id' => $id]);

            return ApiResponse::errorNotFound("No se encontraron datos del programa.");
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar programa.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar programa.");
        } catch (Exception $e) {
            $exceptionType = get_class($e);
            Log::error('Ocurrió un error inesperado al obtener programa.', [
                'exception_type' => $exceptionType,
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado.");
        }
    }
}
