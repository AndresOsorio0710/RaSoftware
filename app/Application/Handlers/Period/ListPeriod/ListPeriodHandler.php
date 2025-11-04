<?php

namespace App\Application\Handlers\Period\ListPeriod;

use App\Core\ApiResponse;
use App\Http\Resources\Period\PeriodResource;
use App\Models\Period;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class ListPeriodHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Maneja la consulta para listar todos los períodos.
     *
     * @return JsonResponse
     */
    public function handler(): JsonResponse
    {
        try {
            $periods = Period::with([
                'program',
                'program.faculty',
                'program.manager'
            ])
                ->orderBy('name', 'asc')
                ->get();

            if ($periods->count() === 0) {
                Log::info('No se tienen períodos registrados.');
                return ApiResponse::errorNotFound('No se tienen períodos registrados.');
            }

            $response = PeriodResource::collection($periods)->toResponse(request())->getData();

            Log::info('Consulta de períodos exitosa.', ['count' => $periods->count()]);

            return ApiResponse::success($response);
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar períodos.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar períodos.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al recuperar períodos.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al recuperar períodos.");
        }
    }
}
