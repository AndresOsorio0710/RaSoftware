<?php

namespace App\Application\Handlers\UserRole\ListUserRole;

use App\Core\ApiResponse;
use App\Http\Resources\UserResource;
use App\Models\Role;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListUserRoleHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(string $roleName): JsonResponse
    {
        try {
            $role = Role::where('name', $roleName)->first();

            if (!$role) {
                Log::info("No se encontó rol $roleName");

                return ApiResponse::errorNotFound("No se encontó rol $roleName");
            }

            $users = $role->users()->get();

            if ($users->count() == 0) {
                Log::info("No se tienen usuarios registrados con el rol $roleName.");
                return ApiResponse::errorNotFound("No se tienen usuarios registrados con el rol $roleName.");
            }

            $response = UserResource::collection($users)->resolve();

            Log::info('Consulta de usuarios por rol exitosa.');
            return ApiResponse::success($response);
        } catch (QueryException $ex) {
            Log::error('Error de base de datos al consultar usuarios por rol.', [
                'exception' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al consultar usuarios por rol.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al consultar usuarios por rol.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => ["role_name" => $roleName,],
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al consultar usuarios por rol.");
        }
    }
}
