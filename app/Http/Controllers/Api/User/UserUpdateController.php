<?php

namespace App\Http\Controllers\Api\User;

use App\Application\Handlers\User\GetUser\GetUserHandler;
use App\Application\Handlers\User\UpdateUser\UpdateUserHandler;
use App\Core\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserUpdateController extends Controller
{
    protected $getUserHandler;
    protected $updateUserHandler;

    public function __construct(
        GetUserHandler $getUserHandler,
        UpdateUserHandler $updateUserHandler,
    ) {
        $this->getUserHandler = $getUserHandler;
        $this->updateUserHandler = $updateUserHandler;
    }

    public function update(string $id, UpdateUserRequest $request): JsonResponse
    {
        Log::info('Inicio de procesamiento de solicitud de actualización de usuario.', ['uuid' => $id]);

        try {
            $data = $request->validated();

            $user = $this->updateUserHandler->handler($id, $data);

            $resource = new UserResource($user);

            Log::info('Usuario actualizado con éxito.', ['uuid' => $id]);

            return ApiResponse::success(
                $resource,
                "Usuario actualizado con éxito."
            );
        } catch (Exception $e) {
            $statusCode = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;

            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                Log::info('No se encontraron datos del usuario.');
                return ApiResponse::errorNotFound("No se encontraron datos del usuario.");
            }

            Log::error('Fallo al actualizar usuario.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::error(
                message: 'Fallo al actualizar usuario: ' . $e->getMessage(),
                status: $statusCode
            );
        }
    }
}
