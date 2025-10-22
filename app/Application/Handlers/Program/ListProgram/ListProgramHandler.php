<?php

namespace App\Application\Handlers\Program\ListProgram;

use App\Core\ApiResponse;
use App\Http\Resources\Program\ProgramResource;
use App\Models\Program;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListProgramHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Maneja la consulta para listar todos los programas.
     *
     * @return JsonResponse
     */
    public function handler(): JsonResponse
    {
        try {
            $programs = Program::with(['faculty', 'manager'])
                ->orderBy('name', 'asc')
                ->get();

            if ($programs->count() === 0) {
                Log::info('No se tienen programas registrados.');
                return ApiResponse::errorNotFound('No se tienen programas registrados.');
            }

            $response = ProgramResource::collection($programs)->toResponse(request())->getData();

            Log::info('Consulta de programas exitosa.', ['count' => $programs->count()]);

            return ApiResponse::success($response);
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar programas.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar programas.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al recuperar programas.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al recuperar programas.");
        }
    }
}
