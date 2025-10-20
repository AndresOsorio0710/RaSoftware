<?php

namespace App\Application\Handlers\Faculty\CreateFaculty;

use App\Core\ApiResponse;
use App\Http\Resources\Faculty\FacultyResource;
use App\Models\Faculty;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreateFacultyHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(array $data): JsonResponse
    {
        try {
            $faculty = Faculty::create($data);

            $response = new FacultyResource($faculty);

            Log::info('Facultad creada exitosamente.', ['faculty_id' => $faculty->id, 'name' => $faculty->name]);

            return ApiResponse::created(
                $response,
                "Facultad creata exitosamente"
            );
        } catch (QueryException $ex) {
            Log::error('Error de base de datos al intentar crear una facultad.', [
                'exception' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al intentar crear la facultad.");
        } catch (Exception $e) {
            Log::error('Error inesperado al crear el rol.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $data,
            ]);

            return ApiResponse::internalServerError("Error inesperado al crear el rol.");
        }
    }
}
