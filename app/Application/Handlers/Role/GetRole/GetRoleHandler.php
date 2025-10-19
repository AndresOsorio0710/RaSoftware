<?php

namespace App\Application\Handlers\Role\GetRole;

use App\Core\ApiResponse;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GetRoleHandler
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
            Log::info("El formato del identificador no es un UUID válido.");
            return ApiResponse::errorConflict("El formato del identificador no es un UUID válido.");
        }

        try {
            $role = Role::findOrFail($id);

            $result = new RoleResource($role);

            Log::info("Rol con ID:$id, encontrado.", ['id' => $id]);

            return ApiResponse::success(
                $result,
                "Rol encontrado."
            );
        } catch (ModelNotFoundException $e) {
            Log::info("Rol con ID:$id, no encontrado.", ['id' => $id]);

            return ApiResponse::errorBadRequest("No se encontraron datos del rol.");
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar rol.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar rol.");
        } catch (Exception $e) {
            $exceptionType = get_class($e);
            Log::error('Ocurrió un error inesperado.', [
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
