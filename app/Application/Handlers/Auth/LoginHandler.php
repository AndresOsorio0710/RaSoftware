<?php

namespace App\Application\Handlers\Auth;

use App\Core\ApiResponse;
use App\Http\Resources\Auth\AuthResource;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginHandler
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handler(string $userName, string $password): JsonResponse
    {
        try {
            $user = User::where('user_name', $userName)
                ->orWhere('email', $userName)
                ->first();

            if (!$user || !Hash::check($password, $user->password)) {
                Log::info('Credenciales inválidas.', ['user_name' => $userName]);

                return ApiResponse::unauthorized();
            }

            if ($user->roles->isEmpty()) {
                Log::info('Acceso denegado: El usuario no tiene roles asignados', ['username' => $userName]);

                return ApiResponse::unauthorized();
            }

            $user->tokens()->delete();

            $token = $user->createToken("auth_token")->plainTextToken;

            $result = new AuthResource($user);

            return ApiResponse::authSuccess(
                $result,
                $token
            );
        } catch (QueryException $ex) {
            Log::error('Error de base de datos al intentar login.', [
                'exception' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'request_url' => request()->fullUrl(),
            ]);

            return ApiResponse::internalServerError("Error de base de datos al intentar login.");
        } catch (Exception $e) {
            Log::error('Error inesperado al hacer login.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => ['user_name' => $userName],
            ]);

            return ApiResponse::internalServerError("Error inesperado al hacer login");
        }
    }
}
