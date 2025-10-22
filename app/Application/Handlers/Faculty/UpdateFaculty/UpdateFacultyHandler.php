<?php

namespace App\Application\Handlers\Faculty\UpdateFaculty;

use App\Core\ApiResponse;
use App\Http\Resources\Faculty\FacultyResource;
use App\Models\Faculty;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UpdateFacultyHandler
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
            Log::info("El formato del identificador no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador no es un UUID válido.");
        }
        try {
            $faculty = Faculty::findOrFail($id);

            $faculty->description = $data['description'];

            $faculty->save();

            $response = new FacultyResource($faculty);

            Log::info('Facultad actualizada con éxito.', ['id' => $id]);
            return ApiResponse::success(
                $response,
                "Facultad actualizada con éxito."
            );
        } catch (ModelNotFoundException $e) {
            Log::info("Facultad con UUID:$id, no encontrada.", ['id' => $id]);

            return ApiResponse::errorBadRequest("No se encontraron datos de la facultad.");
        } catch (InvalidArgumentException $e) {
            Log::error('Error por argumentos invalidos.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::errorConflict("Error por argumentos invalidos.");
        } catch (QueryException $e) {
            Log::error('Error de base de datos al actualizar facultad.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al actualizar facultad.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado.");
        }
    }
}
