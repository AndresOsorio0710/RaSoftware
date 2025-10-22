<?php

namespace App\Application\Handlers\Role\CreateRole;

use App\Core\ApiResponse;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreateRoleHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(array $data): JsonResponse
    {
        try {
            $role = Role::create($data);

            $result = new RoleResource($role);

            Log::info('Rol creado exitosamente.', ['role_id' => $role->id, 'name' => $role->name]);

            return ApiResponse::created(
                $result,
                "Rol creado exitosamente."
            );
        } catch (QueryException $ex) {
            Log::error('Error de base de datos al intentar crear un rol.', [
                'exception' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al intentar crear el rol.");
        } catch (Exception $e) {
            Log::error('Error inesperado al crear el rol.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $data,
            ]);

            return ApiResponse::internalServerError("Error inesperado al crear el rol.");
        }
    }
}
