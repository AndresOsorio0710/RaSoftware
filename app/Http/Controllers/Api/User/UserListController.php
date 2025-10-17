<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Application\Queries\User\GetAllUsers\GetAllUsersQuery;
use App\Application\Handlers\User\GetAllUsers\GetAllUsersHandler;
use App\Core\ApiResponse;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;

class UserListController extends Controller
{
    public function index(GetAllUsersHandler $handler): JsonResponse
    {
        try {
            $query = new GetAllUsersQuery();
            
            // El handler devuelve el objeto paginado o lanza una excepción.
            $users = $handler->handle($query); 

            // 1. **Verificación de Resultados**
            if ($users->isEmpty()) {
                return ApiResponse::errorNotFound("No se encontraron usuarios para la consulta.");
            }
            
            // 1. Aplicar el Resource al resultado paginado
            // Usamos ::collection($paginatedUsers) para aplicar el Resource a cada elemento del paginador.
            $resourceCollection = UserResource::collection($users)->toResponse(request())->getData();

            return ApiResponse::success(
                $resourceCollection,
                "Lista de usuarios obtenida exitosamente."
            );

        } catch (Exception $e) {
            // 3. Manejar la excepción lanzada por el Handler
            $statusCode = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
            
            return ApiResponse::error(
                message: 'Error: ' . $e->getMessage(),
                status: $statusCode
            );
        }
    }
}
