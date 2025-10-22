<?php

namespace App\Application\Handlers\UserRole\DeleteUserRole;

use App\Core\ApiResponse;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DeleteUserRoleHandler
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

            $deletedCount = $user->roles()->detach($roleId);

            if ($deletedCount === 0) {
                Log::info(
                    "La relación de rol y usuario no existe para ser revocada.",
                    [
                        "user_id" => $userId,
                        "role_id" => $roleId
                    ]
                );

                return ApiResponse::errorNotFound('La relación de rol y usuario no existe para ser revocada.');
            }

            Log::info("Rol revocado al usuario exitosamente.");

            return ApiResponse::success(
                null,
                "Rol revocado al usuario exitosamente."
            );
        } catch (QueryException $ex) {
            Log::error('Error de base de datos al revocar el rol.', [
                'exception' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al revocar el rol.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al revocar el rol.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => [
                    "user_id" => $userId,
                    "role_id" => $roleId
                ],
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al revocar el rol.");
        }
    }
}
