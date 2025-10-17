<?php

namespace App\Http\Controllers\Api\User;

use App\Application\Commands\User\RegisterUser\RegisterUserCommand;
use App\Application\Handlers\User\RegisterUser\RegisterUserHandler;
use App\Core\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(
        RegisterUserRequest $request,
        RegisterUserHandler $handler
    )
    {
        $command = new RegisterUserCommand(
            firstName: $request->first_name,
            lastName: $request->last_name,
            userName: $request->user_name,
            idNumber: $request->id_number,
            email: $request->email,
            password: $request->password,
        );

        try {
            // Usamos DB::transaction para asegurar que si algo falla, no se guarda nada.
            $result = DB::transaction(fn() => $handler->handle($command));
            
            // 4. Respuesta Exitosa: 201 Created
            return ApiResponse::created(
                data: new UserResource($result['user']),
                message: "User registered successfully."
            );

        } catch (\Throwable $e) {
            // Manejo de excepciones genéricas o de dominio que puedan surgir.
            // Aunque RegisterUserRequest ya maneja unicidad (422), es bueno tener un catch all.

            // Si fuera una excepción de negocio más específica (ej: RoleNotFound), la capturaríamos aquí.
            return ApiResponse::errorConflict($e->getMessage()); // Usar 409 para errores de negocio
        }
    }
}
