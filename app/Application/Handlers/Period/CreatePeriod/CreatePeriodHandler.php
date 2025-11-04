<?php

namespace App\Application\Handlers\Period\CreatePeriod;

use App\Core\ApiResponse;
use App\Http\Resources\Period\PeriodResource;
use App\Models\Period;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreatePeriodHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Maneja la lógica para crear un nuevo período.
     * * @param array $data Datos validados del Request.
     * @return JsonResponse
     */
    public function handler(array $data): JsonResponse
    {
        try {
            $period = Period::create($data);

            $period->refresh()->load(
                [
                    'program',
                    'program.faculty',
                    'program.manager'
                ]
            );

            $response = PeriodResource::make($period)->resolve();

            Log::info('Período creado exitosamente.', [
                'period_id' => $period->id,
                'data' => $data
            ]);

            return ApiResponse::created(
                $response,
                "Período creado exitosamente."
            );
        } catch (QueryException $ex) {
            Log::error('Error de base de datos al crear el período.', [
                'exception' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'data' => $data,
            ]);

            return ApiResponse::internalServerError("Error de base de datos al crear el período.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al crear el período.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $data,
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al crear el período.");
        }
    }
}
