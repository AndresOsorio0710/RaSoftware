<?php

namespace App\Application\Handlers\Faculty\GetFaculty;

use App\Core\ApiResponse;
use App\Http\Resources\Faculty\FacultyResource;
use App\Models\Faculty;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GetFacultyHandler
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
            Log::info("El formato del identificador no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador no es un UUID válido.");
        }

        try {
            $faculty = Faculty::findOrFail($id);

            $response = new FacultyResource($faculty);

            Log::info("Facultad con ID:$id, encontrada.", ['id' => $id]);

            return ApiResponse::success(
                $response,
                "Facultad encontrada."
            );
        } catch (ModelNotFoundException $e) {
            Log::info("Facultad con ID:$id, no encontrada.", ['id' => $id]);

            return ApiResponse::errorBadRequest("No se encontraron datos de la facultad.");
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar facultad.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar facultad.");
        } catch (Exception $e) {
            $exceptionType = get_class($e);
            Log::error('Ocurrió un error inesperado.', [
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
