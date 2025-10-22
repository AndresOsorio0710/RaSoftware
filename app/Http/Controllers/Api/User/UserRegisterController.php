<?php

namespace App\Http\Controllers\Api\User;

use App\Application\Commands\User\RegisterUser\RegisterUserCommand;
use App\Application\Handlers\User\RegisterUser\RegisterUserHandler;
use App\Core\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRegisterController extends Controller
{
    public function register(
        RegisterUserRequest $request,
        RegisterUserHandler $handler
    )
    {
        Log::info('Inicio de procesamiento de solicitud de egistro de usuario.');
        $command = new RegisterUserCommand(
            firstName: $request->first_name,
            lastName: $request->last_name,
            idNumber: $request->id_number,
            email: $request->email,
            password: $request->password,
        );

        try {
            $result = DB::transaction(fn() => $handler->handle($command));
            
            Log::info('Usuario registrado exitosamente.');
            return ApiResponse::created(
                data: new UserResource($result['user']),
                message: "Usuario registrado exitosamente."
            );

        } catch (\Throwable $e) {
            $statusCode = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;

            Log::error('Fallo al registrar usuario.', [
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
