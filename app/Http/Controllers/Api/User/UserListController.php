<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Application\Queries\User\GetAllUsers\GetAllUsersQuery;
use App\Application\Handlers\User\GetAllUsers\GetAllUsersHandler;
use App\Core\ApiResponse;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserListController extends Controller
{
    public function index(GetAllUsersHandler $handler): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de lista de usuarios.');
        try {
            $query = new GetAllUsersQuery();
            
            // El handler devuelve el objeto paginado o lanza una excepción.
            $users = $handler->handle($query); 

            // 1. **Verificación de Resultados**
            if ($users->isEmpty()) {
                Log::info('No se encontraron usuarios para la consulta.');
                return ApiResponse::errorNotFound("No se encontraron usuarios para la consulta.");
            }
            
            // 1. Aplicar el Resource al resultado paginado
            // Usamos ::collection($paginatedUsers) para aplicar el Resource a cada elemento del paginador.
            $resourceCollection = UserResource::collection($users)->toResponse(request())->getData();

            Log::info('Lista de usuarios obtenida exitosamente.');
            return ApiResponse::success(
                $resourceCollection,
                "Lista de usuarios obtenida exitosamente."
            );

        } catch (Exception $e) {
            $statusCode = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
            
            Log::error('Fallo al obtener datos externos.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);
            
            return ApiResponse::error(
                message: 'Error: ' . $e->getMessage(),
                status: $statusCode
            );
        }
    }
}
