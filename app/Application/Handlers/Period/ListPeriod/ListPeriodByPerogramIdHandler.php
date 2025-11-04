<?php

namespace App\Application\Handlers\Period\ListPeriod;

use App\Core\ApiResponse;
use App\Http\Resources\Period\PeriodResource;
use App\Models\Period;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ListPeriodByPerogramIdHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Maneja la lógica para obtener todos los períodos asociados a un Program ID.
     *
     * @param string $programId El UUID del programa.
     * @return JsonResponse
     */
    public function handler(string $programId): JsonResponse
    {
        if (!Str::isUuid($programId)) {
            Log::info("El formato del identificador de facultad proporcionado ($programId) no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador de facultad no es un UUID válido.");
        }
        try {
            $periods = Period::with([
                'program',
                'program.faculty',
                'program.manager'
            ])
                ->where('program_id', $programId)
                ->orderBy('name', 'asc')
                ->get();

            if ($periods->count() === 0) {
                Log::info(
                    'No se tienen períodos registrados en el programa indicado.',
                    ['program_id' => $programId],
                );
                return ApiResponse::errorNotFound('No se tienen períodos registrados en el programa indicado.');
            }

            $response = PeriodResource::collection($periods)->toResponse(request())->getData();

            Log::info('Consulta de períodos exitosa.', ['count' => $periods->count()]);

            return ApiResponse::success($response);
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar períodos por programa_id.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
                ['program_id' => $programId],
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar períodos por programa_id.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al recuperar períodos por programa_id.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
                ['program_id' => $programId],
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al recuperar períodos por programa_id.");
        }
    }
}
