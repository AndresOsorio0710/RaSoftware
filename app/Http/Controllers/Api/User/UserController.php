<?php

namespace App\Http\Controllers\Api\User;

use App\Application\Handlers\User\GetUser\GetUserHandler;
use App\Core\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $handler;

    public function __construct(GetUserHandler $handler)
    {
        $this->handler = $handler;
    }

    public function findById(string $id): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de información de usuario por id.');

        if (empty($id)) {
            Log::info('El parámetro "id" es obligatorio en la consulta.');

            return ApiResponse::errorConflict('El parámetro "id" es obligatorio en la consulta.');
        }

        try{
            $user = $this->handler->handler($id);

            $resource = new UserResource($user);

            Log::info('Datos de usuario encontrados.');

            return ApiResponse::success(
                $resource,
                "Datos de usuario encontrados."
            );
        }catch (Exception $e) {
            $exceptionType = get_class($e);
            $statusCode = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
            
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                Log::info('No se encontraron datos del usuario.');
                return ApiResponse::errorNotFound("No se encontraron datos del usuario.");
            }

            Log::error('Fallo al obtener datos de usuario.', [
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
