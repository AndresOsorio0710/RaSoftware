<?php

namespace App\Application\Handlers\Period\GetPeriod;

use App\Core\ApiResponse;
use App\Http\Resources\Period\PeriodResource;
use App\Models\Period;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GetPeriodHandler
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
            $period = Period::with([
                'program',
                'program.faculty',
                'program.manager'
            ])->findOrFail($id);

            $response = new PeriodResource($period);

            Log::info("Periodo con ID:$id, encontrado.", ['id' => $id]);

            return ApiResponse::success(
                $response,
                "Perioda encontrado."
            );
        } catch (ModelNotFoundException $e) {
            Log::info("Periodo con ID:$id, no encontrado.", ['id' => $id]);

            return ApiResponse::errorNotFound("No se encontraron datos del periodo.");
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar periodo.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar periodo.");
        } catch (Exception $e) {
            $exceptionType = get_class($e);
            Log::error('Ocurrió un error inesperado al obtener periodo.', [
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
