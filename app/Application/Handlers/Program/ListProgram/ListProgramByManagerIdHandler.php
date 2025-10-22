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

class ListProgramByManagerIdHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Maneja la lógica para obtener todos los programas gestionados por un Manager ID específico.
     *
     * @param string $managerId El UUID del usuario Manager.
     * @return JsonResponse
     */
    public function handler(string $managerId): JsonResponse
    {
        if (!Str::isUuid($managerId)) {
            Log::info("El formato del identificador de Manager proporcionado ($managerId) no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador de Manager no es un UUID válido.");
        }

        try {
            $programs = Program::with(['faculty', 'manager'])
                ->where('manager_id', $managerId)
                ->orderBy('name', 'asc')
                ->get();

            if ($programs->count() === 0) {
                Log::info(
                    'No se tienen programas registrados para el Manager indicado.',
                    ['manager_id' => $managerId],
                );
                return ApiResponse::errorNotFound('No se tienen programas registrados para el Manager indicado.');
            }

            $response = ProgramResource::collection($programs)->toResponse(request())->getData();

            Log::info("Programas consultados con éxito para el Manager ID:$managerId. Resultados: " . $programs->count());

            return ApiResponse::success(
                $response,
                "Programas gestionados por el manager obtenidos con éxito."
            );
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar programas por Manager ID.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
                ['manager_id' => $managerId],
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar programas por Manager ID.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al recuperar programas por Manager ID.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
                ['manager_id' => $managerId],
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al recuperar programas.");
        }
    }
}
