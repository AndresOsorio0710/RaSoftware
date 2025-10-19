<?php

namespace App\Application\Handlers\Role\ListRole;

use App\Core\ApiResponse;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ListRoleHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(): JsonResponse
    {
        try {
            $roles = Role::orderBy('name', 'asc')->get();

            if ($roles->count() == 0) {
                Log::info('No se tienen roles registrados.');
                return ApiResponse::errorNotFound('No se tienen roles registrados.');
            }

            $result = RoleResource::collection($roles)->toResponse(request())->getData();

            Log::info('Consulta de roles exitosa.');
            return ApiResponse::success($result);
        } catch (QueryException $e) {
            Log::error('Error de base de datos al recuperar roles.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al recuperar roles.");
        } catch (Exception $e) {
            Log::error('Ocurrió un error inesperado al recuperar roles.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Ocurrió un error inesperado al recuperar roles.");
        }
    }
}
