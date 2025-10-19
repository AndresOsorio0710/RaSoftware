<?php

namespace App\Application\Handlers\UserRole\CreateUserRole;

use App\Core\ApiResponse;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CreateUserRoleHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(string $userId, string $roleId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);

            $currentRoleIds = $user->roles()->pluck('role_id')->toArray();

            if (in_array($roleId, $currentRoleIds)) {
                Log::info(
                    "El rol ya está asignado a este usuario.",
                    [
                        "user_id" => $userId,
                        "role_id" => $roleId
                    ]
                );
                return ApiResponse::errorValidation("El rol ya está asignado a este usuario.");
            }

            $user->roles()->attach($roleId);

            Log::info("Rol asignado al usuario exitosamente.");

            return ApiResponse::success(
                null,
                "Rol asignado al usuario exitosamente."
            );
        } catch (QueryException $ex) {
            Log::error('Error de base de datos al asignar el rol.', [
                'exception' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al asignar el rol.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al asignar el rol.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => [
                    "user_id" => $userId,
                    "role_id" => $roleId
                ],
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al asignar el rol.");
        }
    }
}
