<?php

namespace App\Application\Handlers\Role\UpdateRole;

use App\Core\ApiResponse;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UpdateRoleHandler
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
            $role = Role::findOrFail($id);

            $role->description = $data['description'];

            $role->save();

            $result = new RoleResource($role);

            Log::info('Rol actualizado con éxito.', ['id' => $id]);
            return ApiResponse::success(
                $result,
                "Rol actualizado con éxito."
            );
        } catch (ModelNotFoundException $e) {
            Log::info("Rol con UUID:$id, no encontrado.", ['id' => $id]);

            return ApiResponse::errorBadRequest("No se encontraron datos del rol.");
        } catch (InvalidArgumentException $e) {
            Log::error('Error por argumentos invalidos.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::errorConflict("Error por argumentos invalidos.");
        } catch (QueryException $e) {
            Log::error('Error de base de datos al actualizar rol.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al actualizar rol.");
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
