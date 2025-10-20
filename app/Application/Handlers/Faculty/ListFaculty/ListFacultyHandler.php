<?php

namespace App\Application\Handlers\Faculty\ListFaculty;

use App\Core\ApiResponse;
use App\Http\Resources\Faculty\FacultyResource;
use App\Models\Faculty;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListFacultyHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(): JsonResponse
    {
        try {
            $faculties = Faculty::orderBy('name', 'asc')->get();

            if ($faculties->count() == 0) {
                Log::info('No se tienen facultades registradas.');
                return ApiResponse::errorNotFound('No se tienen facultades registradas.');
            }

            $response = FacultyResource::collection($faculties)->toResponse(request())->getData();

            Log::info('Consulta de facultades exitosa.');
            return ApiResponse::success($response);
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar facultades.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar facultades.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al recuperar facultades.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al recuperar facultades.");
        }
    }
}
