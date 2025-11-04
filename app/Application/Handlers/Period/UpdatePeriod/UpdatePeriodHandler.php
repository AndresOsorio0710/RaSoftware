<?php

namespace App\Application\Handlers\Period\UpdatePeriod;

use App\Core\ApiResponse;
use App\Http\Resources\Period\PeriodResource;
use App\Models\Period;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UpdatePeriodHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(string $id, array $data): JsonResponse
    {
        if (!Str::isUuid($id)) {
            Log::info("El formato del identificador proporcionado ($id) no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador no es un UUID válido.");
        }

        try {
            $period = Period::findOrFail($id);

            $period->name = $data['name'];
            $period->period_number = $data['period_number'];
            $period->start_at = $data['start_at'];
            $period->end_at = $data['end_at'];
            $period->save();

            $period->refresh()->load(['program', 'program.faculty', 'program.manager']);

            $response = new PeriodResource($period);
            Log::info('Periodo actualizado con éxito.', ['id' => $id, 'name' => $period->name]);
            return ApiResponse::success(
                $response,
                "Periodo actualizado con éxito."
            );
        } catch (ModelNotFoundException $e) {
            Log::info("Periodo con UUID:$id, no encontrado.", ['id' => $id]);
            return ApiResponse::errorNotFound("No se encontraron datos del periodo.");
        } catch (InvalidArgumentException $e) {
            Log::error('Error por argumentos inválidos durante la actualización.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::errorConflict("Error por argumentos inválidos.");
        } catch (QueryException $e) {
            Log::error('Error de base de datos al actualizar periodo.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al actualizar periodo.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado durante la actualización del periodo.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado.");
        }
    }
}
